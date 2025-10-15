<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class RolePermissionController extends Controller
{
   
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $roles = Role::where('guard_name', 'api')
            ->where('name', 'like', '%' . $search . '%')
            ->with('permissions')
            ->paginate($perPage);

        $permissions = Permission::where('guard_name', 'api')
            ->get()
            ->groupBy(function ($item) {
                return explode('-', $item->name)[0]; 
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'roles' => $roles,
                'permissions' => $permissions,
            ],
        ]);
    }

   
    public function show($id)
    {
        $role = Role::where('guard_name', 'api')
            ->with('permissions')
            ->findOrFail($id);

        $allPermissions = Permission::where('guard_name', 'api')
            ->get()
            ->map(function ($permission) use ($role) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'selected' => $role->permissions->contains('id', $permission->id),
                ];
            })
            ->groupBy(function ($item) {
                return explode('-', $item['name'])[0]; 
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'role' => [
                    'id' => $role->id,
                    'name' => $role->name,
                ],
                'permissions' => $allPermissions,
            ],
        ]);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'api',
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'API role created successfully.',
            'data' => $role->load('permissions'),
        ]);
    }

  
    public function update(Request $request, $id)
    {
        $role = Role::where('guard_name', 'api')->findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

     
        $role->update(['name' => $validated['name']]);

       
        if (isset($validated['permissions'])) {
            foreach ($validated['permissions'] as $permName) {
                $permission = Permission::where('name', $permName)
                    ->where('guard_name', 'api')
                    ->first();

                if ($permission) {
                    if ($role->hasPermissionTo($permission)) {
                        $role->revokePermissionTo($permission);
                    } else {
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'API role updated successfully (toggled permissions).',
            'data' => $role->load('permissions'),
        ]);
    }

   
    public function destroy($id)
    {
        try {
            $role = Role::where('guard_name', 'api')->findOrFail($id);
            $role->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'API role deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('API role deletion failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete role. It may be assigned to users.',
            ], 400);
        }
    }

   
    public function getPermissions()
    {
        $permissions = Permission::where('guard_name', 'api')
            ->get()
            ->groupBy(function ($item) {
                return explode('-', $item->name)[0];
            });

        return response()->json([
            'status' => 'success',
            'data' => $permissions,
        ]);
    }
}
