<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{

   public function index(Request $request)
{
    $search = $request->get('search', '');
    $perPage = $request->get('per_page', 10);
    $role = $request->get('role'); // role filter

    $users = User::query()
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->when($role, function ($query, $role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
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
            'phone' => 'nullable',
            'photo'    => 'nullable|image', 
        ]);

        $photoUrl = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('user_photos', 'public');
            $photoUrl = url('storage/' . $path);
        }

        $user = User::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'is_approved' => false,
            'photo'       => $photoUrl,
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
            'photo'    => 'nullable|image',
            'phone' => 'nullable',
            'remove_photo' => 'nullable|boolean',
        ]);

        
        $photoUrl = $user->photo;
        if ($request->boolean('remove_photo') && $photoUrl) {
            if (str_contains($photoUrl, url('/'))) {
                $relativePath = str_replace(url('storage') . '/', '', $photoUrl);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            }
            $photoUrl = null;
        }

        
        if ($request->hasFile('photo')) {
            if ($photoUrl && str_contains($photoUrl, url('/'))) {
                $relativePath = str_replace(url('storage') . '/', '', $photoUrl);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            }

            $path = $request->file('photo')->store('user_photos', 'public');
            $photoUrl = url('storage/' . $path);
        }

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
             'phone' => $validated['phone'] ?? null,
            'role'  => $validated['role'],
            'photo' => $photoUrl,
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
