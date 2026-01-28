<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Facades\Activity;


class AgentManagementController extends Controller
{


    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');
        $user = auth('api')->user();

        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'agent');
        });

        // If logged-in user is an agent, only show their own entry
        if ($user && $user->hasRole('agent')) {
            $query->where('id', $user->id);
        }

        $query->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->withCount('customers')
            ->addSelect([
                'target_achieved' => DB::table('vehicle_bids')
                    ->join('users as customers', 'customers.id', '=', 'vehicle_bids.user_id')
                    ->whereColumn('customers.agent_id', 'users.id')
                    ->where('vehicle_bids.status', 'accepted')
                    ->selectRaw('COUNT(vehicle_bids.id)')
            ])
            ->orderBy('created_at', 'desc');

        $agents = $query->paginate($perPage);

        $agents->getCollection()->transform(function ($agent) {
            return [
                'id'               => $agent->id,
                'name'             => $agent->name,
                'email'            => $agent->email,
                'phone'            => $agent->phone,
                'role'             => 'agent',
                'photo'            => $agent->photo,
                'target'           => $agent->target,
                'customers_count'  => $agent->customers_count,
                'target_achieved'  => (int) $agent->target_achieved,
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
            'phone'    => 'nullable|string',
            'password' => 'required|string|min:6',
            'photo'    => 'nullable|image',
            'target'    => 'nullable',
        ]);

        $photoUrl = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('agent_photos', 'public');
            $photoUrl = url('storage/' . $path);
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
        $admin = auth('api')->user();

        if ($admin) {
            Activity::causedBy($admin)
                ->performedOn($agent)
                ->event('created')
                ->log("Admin ({$admin->name}) created new Dree: {$agent->name}");
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Dree created successfully',
            'data'    => $agent,
        ], 201);
    }

    public function show($id)
    {
        $user = auth('api')->user();

        // If logged-in user is an agent, override the ID to show only their own profile
        if ($user && $user->hasRole('agent')) {
            $id = $user->id;
        }

        $agent = User::where('role', 'agent')
            ->with(['Customers']) // load customers first
            ->find($id);

        if (!$agent) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Agent not found.',
            ], 404);
        }

        // Loop through customers to attach bids and vehicles
        $agent->Customers->each(function ($customer) {
            // Load all bids for the customer
            $customer->vehicleBids = $customer->vehicleBids()->with('vehicle.brand', 'vehicle.vehicleModel')->get();

            // Get unique vehicles customer has bid on
            $customer->biddedVehicles = $customer->vehicleBids->pluck('vehicle')->unique('id')->values();
        });

        return response()->json([
            'status' => 'success',
            'data'   => $agent,
        ]);
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $id,
            'phone'       => 'nullable|string',
            'password'    => 'nullable|string|min:6',
            'photo'       => 'nullable|image',
            'target'      => 'nullable',
            'customers'   => 'nullable|array',
            'remove_image' => 'nullable|boolean',
        ]);

        $agent = User::where('role', 'agent')->findOrFail($id);

        $photoUrl = $agent->photo;

        if ($request->boolean('remove_image')) {
            if ($photoUrl && str_contains($photoUrl, url('/'))) {
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
            'target'   => $request->target,
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
        $admin = auth('api')->user();
        if ($admin) {
            Activity::causedBy($admin)
                ->performedOn($agent)
                ->event('updated')
                ->log("Admin ({$admin->name}) updated Dree: {$agent->name}");
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent updated successfully',
            'data'    => $agent->load('customers'),
        ]);
    }

    public function assignCustomers(Request $request, $agentId)
    {
        $user = auth('api')->user();

        // If logged-in user is an agent, they cannot assign customers
        if ($user && $user->hasRole('agent')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized. Agents cannot assign customers.',
            ], 403);
        }

        $request->validate([
            'customer_ids'   => 'nullable',
            'customer_ids.*' => 'nullable|exists:users,id',
        ]);

        $agent = User::where('role', 'agent')->findOrFail($agentId);


        User::where('agent_id', $agent->id)->update(['agent_id' => null]);


        User::whereIn('id', $request->customer_ids ?? [])
            ->update(['agent_id' => $agent->id]);

        $assigned = User::whereIn('id', $request->customer_ids ?? [])
            ->select('id', 'name', 'email', 'agent_id')
            ->get();
        $admin = auth('api')->user();
        if ($admin) {
            Activity::causedBy($admin)
                ->performedOn($agent)
                ->event('assigned_customers')
                ->log("Admin ({$admin->name}) assigned customers to Dree: {$agent->name}");
        }
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

        // If logged-in user is an agent, only allow viewing their own customers
        if ($user->hasRole('agent') && $user->id !== (int)$agentId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized access. You can only view your own customers.',
            ], 403);
        }

        $agent = User::where('role', 'agent')->find($agentId);

        if (!$agent) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Agent not found.',
            ], 404);
        }

        // Assigned customers
        $assigned = User::where('role', 'customer')
            ->where('agent_id', $agentId)
            ->select('id', 'name', 'email', 'agent_id')
            ->get();

        // Search filter for unassigned customers
        $search = $request->get('search');

        $unassigned = User::where('role', 'customer')
            ->whereNull('agent_id')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->select('id', 'name', 'email', 'agent_id')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'agent'                => $agent,
                'assigned_customers'   => $assigned,
                'unassigned_customers' => $unassigned,
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
        $admin = auth('api')->user();
        if ($admin) {
            Activity::causedBy($admin)
                ->event('deleted')
                ->log("Admin ({$admin->name}) deleted Dree: {$agent->name} and unlinked assigned customers");
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Agent deleted successfully and assigned customers unlinked.',
        ]);
    }
}
