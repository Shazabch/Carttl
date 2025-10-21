<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ManagerCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $managers = User::where('role', 'manager')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->with(['managedCustomers.customer:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $managers->getCollection()->transform(function ($manager) {
            $customers = $manager->managedCustomers->map(function ($relation) {
                return [
                    'id'    => $relation->customer->id,
                    'name'  => $relation->customer->name,
                    'email' => $relation->customer->email,
                ];
            });
            return [
                'id'          => $manager->id,
                'name'        => $manager->name,
                'email'       => $manager->email,
                'phone'       => $manager->phone,
                'bio'         => $manager->bio,
                'role'        => $manager->role,
                'is_approved' => $manager->is_approved,
                'created_at'  => $manager->created_at,
                'updated_at'  => $manager->updated_at,
                'customers'   => $customers,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $managers,
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

        $manager = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'manager',
        ]);

        if (!empty($request->customer_ids)) {
            foreach ($request->customer_ids as $customerId) {
                ManagerCustomer::updateOrCreate(
                    ['customer_id' => $customerId],
                    ['manager_id' => $manager->id]
                );
            }
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Manager created successfully',
            'manager'   => $manager->load('managedCustomers.customer'),
        ]);
    }

    public function getCustomers($managerId)
    {
        $manager = User::findOrFail($managerId);

        $customers = ManagerCustomer::where('manager_id', $manager->id)
            ->with('customer:id,name,email')
            ->get()
            ->pluck('customer');

        return response()->json([
            'status'    => 'success',
            'manager'   => $manager,
            'customers' => $customers,
        ]);
    }

    // ✅ Updated and consistent update() method
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users,email,' . $id,
            'password'      => 'nullable|min:6',
            'customer_ids'  => 'array',
            'customer_ids.*' => 'exists:users,id',
        ]);

        $manager = User::where('role', 'manager')->findOrFail($id);

        // Update manager info
        $manager->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $manager->password,
        ]);

        // Remove all old customer links
        ManagerCustomer::where('manager_id', $manager->id)->delete();

        // Reassign new customers
        if (!empty($request->customer_ids)) {
            foreach ($request->customer_ids as $customerId) {
                ManagerCustomer::updateOrCreate(
                    ['customer_id' => $customerId],
                    ['manager_id'  => $manager->id]
                );
            }
        }

        // Reload manager with relationships
        $manager->load('managedCustomers.customer');

        // Transform response
        $customers = $manager->managedCustomers->map(function ($relation) {
            return [
                'id'    => $relation->customer->id,
                'name'  => $relation->customer->name,
                'email' => $relation->customer->email,
            ];
        });

        return response()->json([
            'status'    => 'success',
            'message'   => 'Manager updated successfully',
            'manager'   => [
                'id'        => $manager->id,
                'name'      => $manager->name,
                'email'     => $manager->email,
                'customers' => $customers,
            ],
        ]);
    }

    public function destroy($id)
    {
        $manager = User::where('role', 'manager')->findOrFail($id);

        // Step 1: Delete all customer assignments linked to this manager
        ManagerCustomer::where('manager_id', $manager->id)->delete();

        // Step 2: Delete the manager itself
        $manager->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Manager deleted successfully',
        ]);
    }
}
