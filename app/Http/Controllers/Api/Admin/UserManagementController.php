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
        $perPage = $request->get('per_page', 10);

        $users = User::query()
            // Filter by role if provided
            ->when($request->filled('role'), function ($query) use ($request) {
                $query->whereHas('roles', function ($q) use ($request) {
                    $q->where('name', $request->role);
                });
            })
            // Filter by search if provided
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
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
        $user = User::with(['roles', 'bids' => function($query) {
            $query->with(['vehicle.brand:id,name', 'vehicle.vehicleModel:id,name'])->latest();
        }])->findOrFail($id);

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
            'package_id'     => 'nullable|exists:packages,id',
            'password' => 'required|string|min:8',
            'phone' => 'nullable',
            'photo'    => 'nullable|image',
            'is_approved' => 'nullable|boolean',
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
            'package_id' => $validated['package_id'] ?? null,
            'is_approved' => $validated['is_approved'] ?? false,
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
            'package_id'     => 'nullable|exists:packages,id',
            'remove_photo' => 'nullable|boolean',
            'is_approved' => 'nullable|boolean',
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
            'package_id' => $validated['package_id'] ?? null,
            'role'  => $validated['role'],
            'photo' => $photoUrl,
            'is_approved' => $validated['is_approved'] ?? $user->is_approved,
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
