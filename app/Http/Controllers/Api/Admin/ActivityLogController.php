<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
   public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);
    $search  = $request->get('search', '');

    $user = auth('api')->user();

    $query = Activity::query()->with('causer');

    // If user is NOT super admin, only show their own activities
    if ($user->role !== 'super_admin') {
        $query->where('causer_id', $user->id);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('description', 'like', "%{$search}%")
              ->orWhereHas('causer', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    $logs = $query->orderBy('created_at', 'desc')->paginate($perPage);

    $logs->getCollection()->transform(function ($log) {
        return [
            'id'          => $log->id,
            'description' => $log->description,
            'causer'      => $log->causer ? [
                'id'    => $log->causer->id,
                'name'  => $log->causer->name,
                'email' => $log->causer->email,
            ] : null,
            'subject'     => $log->subject_type ? [
                'type' => $log->subject_type,
                'id'   => $log->subject_id,
            ] : null,
            'event'       => $log->event,
            'created_at'  => $log->created_at,
        ];
    });

    return response()->json([
        'status' => 'success',
        'data'   => $logs,
    ]);
}
public function bulkDelete(Request $request)
{
    $user = auth('api')->user();

    // Only super admin can delete logs
    if ($user->role !== 'super_admin') {
        return response()->json([
            'status'  => 'error',
            'message' => 'Unauthorized to delete logs.',
        ], 403);
    }

    $request->validate([
        'ids'   => 'required|array',
        'ids.*' => 'integer|exists:activity_log,id',
    ]);

    $ids = $request->ids;

    Activity::whereIn('id', $ids)->delete();

    return response()->json([
        'status'  => 'success',
        'message' => count($ids) . ' logs deleted successfully.',
    ]);
}

}
