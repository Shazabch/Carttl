<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{

    public function index(Request $request)
    {
        $search  = $request->get('search', '');
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
            'data'   => [
                'roles'       => $roles,
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
                    'id'       => $permission->id,
                    'name'     => $permission->name,
                    'selected' => $role->permissions->contains('id', $permission->id),
                ];
            })
            ->groupBy(function ($item) {
                return explode('-', $item['name'])[0];
            });

        return response()->json([
            'status' => 'success',
            'data'   => [
                'role'        => [
                    'id'   => $role->id,
                    'name' => $role->name,
                ],
                'permissions' => $allPermissions,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create([
            'name'       => $validated['name'],
            'guard_name' => 'api',
        ]);

        if (! empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'API role created successfully.',
            'data'    => $role->load('permissions'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::where('guard_name', 'api')->findOrFail($id);

        $validated = $request->validate([
            'name'          => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

       
        $role->update(['name' => $validated['name']]);

                                    
        $role->syncPermissions([]); 

        
        if (! empty($validated['permissions'])) {
            $newPermissions = Permission::whereIn('name', $validated['permissions'])
                ->where('guard_name', 'api')
                ->get();

            $role->syncPermissions($newPermissions);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Role updated successfully',
            'data'    => $role->load('permissions'),
        ]);
    }

    public function addPermissions(Request $request, $roleId)
    {
        $role = Role::where('guard_name', 'api')->findOrFail($roleId);

        $validated = $request->validate([
            'permissions'   => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $added = [];

        foreach ($validated['permissions'] as $permName) {
            $permission = Permission::where('name', $permName)
                ->where('guard_name', 'api')
                ->first();

            if ($permission && ! $role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
                $added[] = $permName;
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Permissions added successfully.',
            'data'    => [
                'role'            => $role->name,
                'added'           => $added,
                'all_permissions' => $role->permissions->pluck('name'),
            ],
        ]);
    }
    public function removePermissions(Request $request, $roleId)
    {
        $role = Role::where('guard_name', 'api')->findOrFail($roleId);

        $validated = $request->validate([
            'permissions'   => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $removed = [];

        foreach ($validated['permissions'] as $permName) {
            $permission = Permission::where('name', $permName)
                ->where('guard_name', 'api')
                ->first();

            if ($permission && $role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
                $removed[] = $permName;
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Permissions removed successfully.',
            'data'    => [
                'role'                  => $role->name,
                'removed'               => $removed,
                'remaining_permissions' => $role->permissions->pluck('name'),
            ],
        ]);
    }

    public function destroy($id)
    {
        try {
            $role = Role::where('guard_name', 'api')->findOrFail($id);
            $role->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'API role deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('API role deletion failed: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
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
            'data'   => $permissions,
        ]);
    }
}
