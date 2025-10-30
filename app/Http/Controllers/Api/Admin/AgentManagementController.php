<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'id'               => $agent->id,
            'name'             => $agent->name,
            'email'            => $agent->email,
            'phone'            => $agent->phone,
            'role'             => $agent->role,
            'customers_count'  => $agent->customers_count,
            'created_at'       => $agent->created_at,
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
            'password' => 'required|string|min:6',
        ]);

        $agent = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'agent',
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $agent = User::where('role', 'agent')->findOrFail($id);

        $agent->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $agent->password,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent updated successfully',
            'data'    => $agent,
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

   
   public function unassignedCustomers()
{
    $customers = User::where('role', 'customer')
        ->whereNull('agent_id')
        ->select('id', 'name', 'email', 'agent_id')
        ->get();

    return response()->json([
        'status' => 'success',
        'data'   => $customers,
    ]);
}

   public function destroy($id)
{
    $agent = User::where('role', 'agent')->findOrFail($id);
    User::where('agent_id', $agent->id)->update(['agent_id' => null]);
    $agent->delete();

    return response()->json([
        'status'  => 'success',
        'message' => 'Agent deleted successfully and assigned customers unlinked.',
    ]);
}

}
