<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AgentManagementController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');

        $query = User::where('role', 'agent')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->withCount('Customers')
            ->orderBy('created_at', 'desc');

        $agents = $query->paginate($perPage);

        $agents->getCollection()->transform(function ($agent) {
            return [
                'id'              => $agent->id,
                'name'            => $agent->name,
                'email'           => $agent->email,
                'phone'           => $agent->phone,
                'role'            => $agent->role,
                'photo'           => $agent->photo,
                'target'           => $agent->target,
                'customers_count' => $agent->customers_count,
                'created_at'      => $agent->created_at,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $agents,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string',
            'password' => 'required|string|min:6',
            'photo'    => 'nullable|image',
            'target'    => 'nullable',
        ]);

        $photoUrl = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('agent_photos', 'public');
            $photoUrl = url('storage/' . $path); // ✅ store full URL
        }

        $agent = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'agent',
            'photo'    => $photoUrl,
            'target'    => $request->target,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent created successfully',
            'data'    => $agent,
        ], 201);
    }

    public function show($id)
    {
        $agent = User::where('role', 'agent')
            ->with('Customers')
            ->find($id);

        if (!$agent) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Agent not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $agent,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $id,
            'phone'     => 'nullable|string',
            'password'  => 'nullable|string|min:6',
            'photo'     => 'nullable|image',
            'target'     => 'nullable',
            'customers' => 'nullable|array',
        ]);

        $agent = User::where('role', 'agent')->findOrFail($id);

        $photoUrl = $agent->photo;

        // Delete old photo if a new one is uploaded
        if ($request->hasFile('photo')) {
            // Delete old if stored in our domain
            if ($photoUrl && str_contains($photoUrl, url('/'))) {
                $relativePath = str_replace(url('storage') . '/', '', $photoUrl);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            }

            $path = $request->file('photo')->store('agent_photos', 'public');
            $photoUrl = url('storage/' . $path);
        }

        $agent->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $agent->password,
            'photo'    => $photoUrl,
            'target'    => $request->target,

        ]);

        if ($request->has('customers')) {
            $customerIds = $request->customers;
            User::where('role', 'customer')
                ->where('agent_id', $agent->id)
                ->whereNotIn('id', $customerIds)
                ->update(['agent_id' => null]);

            User::where('role', 'customer')
                ->whereIn('id', $customerIds)
                ->update(['agent_id' => $agent->id]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent updated successfully',
            'data'    => $agent->load('customers'),
        ]);
    }
      public function assignCustomers(Request $request, $agentId)
    {
        $request->validate([
            'customer_ids'   => 'required|array|min:1',
            'customer_ids.*' => 'exists:users,id',
        ]);

        $agent = User::where('role', 'agent')->findOrFail($agentId);


        User::where('agent_id', $agent->id)->update(['agent_id' => null]);


        User::whereIn('id', $request->customer_ids)
            ->update(['agent_id' => $agent->id]);

        $assigned = User::whereIn('id', $request->customer_ids)
            ->select('id', 'name', 'email', 'agent_id')
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Customers assigned to agent successfully',
            'data'    => [
                'agent'     => $agent->only(['id', 'name', 'email']),
                'customers' => $assigned,
            ],
        ]);
    }


    public function customersByAgent(Request $request, $agentId)
    {
        
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized access.',
            ], 401);
        }

      
        $agent = User::where('role', 'agent')->find($agentId);

        if (!$agent) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Agent not found.',
            ], 404);
        }

        
        $assigned = User::where('role', 'customer')
            ->where('agent_id', $agentId)
            ->select('id', 'name', 'email', 'agent_id')
            ->get();

       
        $unassigned = User::where('role', 'customer')
            ->whereNull('agent_id')
            ->select('id', 'name', 'email', 'agent_id')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'agent'                 => $agent,
                'assigned_customers'    => $assigned,
                'unassigned_customers'  => $unassigned,
            ],
        ]);
    }


    public function destroy($id)
    {
        $agent = User::where('role', 'agent')->findOrFail($id);

        if ($agent->photo && str_contains($agent->photo, url('/'))) {
            $relativePath = str_replace(url('storage') . '/', '', $agent->photo);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        User::where('agent_id', $agent->id)->update(['agent_id' => null]);
        $agent->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent deleted successfully and assigned customers unlinked.',
        ]);
    }
}
