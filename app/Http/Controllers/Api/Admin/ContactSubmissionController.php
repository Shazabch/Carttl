<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;

class ContactSubmissionController extends Controller
{
   
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'DESC');
        $perPage = $request->get('per_page', 10);

        $submissions = ContactSubmission::query()
            ->when($search, function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $submissions,
        ]);
    }

   
    public function show($id)
    {
        $submission = ContactSubmission::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $submission,
        ]);
    }

  
    public function destroy($id)
    {
        $submission = ContactSubmission::findOrFail($id);
        $submission->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Submission deleted successfully.',
        ]);
    }
}
