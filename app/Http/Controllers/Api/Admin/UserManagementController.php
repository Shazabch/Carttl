<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage);

        $roles = Role::where('guard_name', 'api')->pluck('name');

        return response()->json([
            'status' => 'success',
            'data' => [
                'users' => $users,
                'roles' => $roles,
            ],
        ]);
    }

   
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'role'     => 'required|string|exists:roles,name',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'is_approved' => false, 
        ]);

        $user->syncRoles($validated['role']);

        return response()->json([
            'status'  => 'success',
            'message' => 'User created successfully.',
            'data'    => $user->load('roles'),
        ]);
    }

   
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role'     => 'required|string|exists:roles,name',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);
        $user->syncRoles($validated['role']);

        return response()->json([
            'status'  => 'success',
            'message' => 'User updated successfully.',
            'data'    => $user->load('roles'),
        ]);
    }

    
    public function toggleApproval($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = !$user->is_approved;
        $user->save();

        $status = $user->is_approved ? 'approved' : 'set to pending';

        return response()->json([
            'status'  => 'success',
            'message' => "User has been {$status}.",
            'data'    => $user,
        ]);
    }

  
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'User deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to delete user. Try again later.',
            ], 400);
        }
    }

   
    public function getRoles()
    {
        $roles = Role::where('guard_name', 'api')->pluck('name');

        return response()->json([
            'status' => 'success',
            'data' => $roles,
        ]);
    }
}
