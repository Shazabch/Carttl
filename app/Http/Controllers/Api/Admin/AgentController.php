<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AgentCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $agents = User::where('role', 'agent')->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->with(['assignedCustomers.customer:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $agents->getCollection()->transform(function ($agent) {
            $customers = $agent->assignedCustomers->map(function ($relation) {
                return [
                    'id'    => $relation->customer->id,
                    'name'  => $relation->customer->name,
                    'email' => $relation->customer->email,
                ];
            });
            return [
                'id'          => $agent->id,
                'name'        => $agent->name,
                'email'       => $agent->email,
                'phone'       => $agent->phone,
                'bio'         => $agent->bio,
                'role'        => $agent->role,
                'is_approved' => $agent->is_approved,
                'created_at'  => $agent->created_at,
                'updated_at'  => $agent->updated_at,
                'customers'   => $customers,
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
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            'customer_ids'  => 'array',
            'customer_ids.*' => 'exists:users,id',
        ]);

        $agent = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'agent',
        ]);

        if (!empty($request->customer_ids)) {
            foreach ($request->customer_ids as $customerId) {
                AgentCustomer::updateOrCreate(
                    ['customer_id' => $customerId],
                    ['agent_id' => $agent->id]
                );
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent created successfully',
            'agent'   => $agent->load('assignedCustomers.customer'),
        ]);
    }

    public function show($agentId)
    {
        $agent = User::findOrFail($agentId);

        $customers = AgentCustomer::where('agent_id', $agent->id)
            ->with('customer:id,name,email')
            ->get()
            ->pluck('customer');

        return response()->json([
            'status'    => 'success',
            'agent'     => $agent,
            'customers' => $customers,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users,email,' . $id,
            'password'      => 'nullable|min:6',
            'customer_ids'  => 'array',
            'customer_ids.*' => 'exists:users,id',
        ]);

        $agent = User::where('role', 'agent')->findOrFail($id);

        $agent->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $agent->password,
        ]);

        AgentCustomer::where('agent_id', $agent->id)->delete();

        if (!empty($request->customer_ids)) {
            foreach ($request->customer_ids as $customerId) {
                AgentCustomer::updateOrCreate(
                    ['customer_id' => $customerId],
                    ['agent_id'  => $agent->id]
                );
            }
        }

        $agent->load('assignedCustomers.customer');

        $customers = $agent->assignedCustomers->map(function ($relation) {
            return [
                'id'    => $relation->customer->id,
                'name'  => $relation->customer->name,
                'email' => $relation->customer->email,
            ];
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent updated successfully',
            'agent'   => [
                'id'        => $agent->id,
                'name'      => $agent->name,
                'email'     => $agent->email,
                'customers' => $customers,
            ],
        ]);
    }

    public function destroy($id)
    {
        $agent = User::where('role', 'agent')->findOrFail($id);

        AgentCustomer::where('agent_id', $agent->id)->delete();

        $agent->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent deleted successfully',
        ]);
    }
}
