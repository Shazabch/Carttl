<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserPreferencesController extends Controller
{
    /**
     * Display a listing of user preferences
     */
    public function index(Request $request)
    {
       $userId = auth()->id();
      
     
        $query = UserPreference::where('user_id', $userId);
        // Filter by active status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $preferences = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $preferences
        ]);
    }

    /**
     * Store a newly created preference
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price_from' => 'nullable|numeric|min:0',
                'price_to' => 'nullable|numeric|min:0',
                'date_form' => 'nullable|date',
                'date_to' => 'nullable|date',
                'mileage_form' => 'nullable|numeric|min:0',
                'mileage_to' => 'nullable|numeric|min:0',
                'body_type' => 'nullable|string',
                'make' => 'nullable|string',
                'model' => 'nullable|string',
                'year_form' => 'nullable|string',
                'year_to' => 'nullable|string',
                // Accept either an array of specs or a JSON-serializable value
                'specs' => 'nullable|array',
                'specs.*' => 'string',
                'location' => 'nullable|string',
                'additional_filters' => 'nullable|array',
                'is_active' => 'nullable|boolean'
            ]);

            $validated['user_id'] = auth()->id();
            $preference = UserPreference::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Preference created successfully',
                'data' => $preference
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Error creating preference: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create preference',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified preference
     */
    public function show($id)
    {
        try {
            $preference = UserPreference::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $preference
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Preference not found'
            ], 404);
        }
    }

    /**
     * Update the specified preference
     */
    public function update(Request $request, $id)
    {
        try {
            $preference = UserPreference::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price_from' => 'nullable|numeric|min:0',
                'price_to' => 'nullable|numeric|min:0',
                'date_form' => 'nullable|date',
                'date_to' => 'nullable|date',
                'mileage_form' => 'nullable|numeric|min:0',
                'mileage_to' => 'nullable|numeric|min:0',
                'body_type' => 'nullable|string',
                'make' => 'nullable|string',
                'model' => 'nullable|string',
                'year_form' => 'nullable|string',
                'year_to' => 'nullable|string',
                'specs' => 'nullable|array',
                'specs.*' => 'string',
                'location' => 'nullable|string',
                'additional_filters' => 'nullable|array',
                'is_active' => 'nullable|boolean'
            ]);

            $preference->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Preference updated successfully',
                'data' => $preference
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Preference not found'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Error updating preference: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update preference',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified preference
     */
    public function destroy($id)
    {
        try {
            $preference = UserPreference::findOrFail($id);
            $preference->delete();

            return response()->json([
                'success' => true,
                'message' => 'Preference deleted successfully'
            ]);

        } catch (\Throwable $e) {
            Log::error('Error deleting preference: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete preference',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get preferences for push notifications
     * Returns active preferences that match certain criteria
     */
    public function getForNotifications(Request $request)
    {
        $query = UserPreference::where('is_active', true);

        // Filter by specific criteria if needed
        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        $preferences = $query->with('user')->get();

        return response()->json([
            'success' => true,
            'data' => $preferences
        ]);
    }
}
