<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite (add/remove)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

        $vehicleId = $request->vehicle_id;

        if (Auth::check()) {
           
            Auth::user()->favoriteVehicles()->toggle($vehicleId);

           
            $isFavorited = Auth::user()->favoriteVehicles()
                ->where('vehicle_id', $vehicleId)
                ->exists();

            return response()->json([
                'status' => 'success',
                'message' => $isFavorited
                    ? 'Vehicle added to favorites.'
                    : 'Vehicle removed from favorites.',
                'is_favorited' => $isFavorited,
            ]);
        }

       
        $favorites = session()->get('favorites', []);

        if (in_array($vehicleId, $favorites)) {
            $favorites = array_diff($favorites, [$vehicleId]);
            $isFavorited = false;
        } else {
            $favorites[] = $vehicleId;
            $isFavorited = true;
        }

        session(['favorites' => $favorites]);

        return response()->json([
            'status' => 'success',
            'message' => $isFavorited
                ? 'Vehicle added to session favorites.'
                : 'Vehicle removed from session favorites.',
            'is_favorited' => $isFavorited,
            'favorites' => array_values($favorites),
        ]);
    }

    /**
     * List user favorites
     */
    public function index()
    {
        if (Auth::check()) {
            $vehicles = Auth::user()->favoriteVehicles()
                ->with(['brand:id,name,image_source', 'vehicleModel:id,name'])
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $vehicles,
            ]);
        }

        // For guest users (session favorites)
        $favorites = session()->get('favorites', []);
        $vehicles = Vehicle::whereIn('id', $favorites)
            ->with(['brand:id,name,image_source', 'vehicleModel:id,name'])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $vehicles,
        ]);
    }

    /**
     * Remove all favorites
     */
    public function clear()
    {
        if (Auth::check()) {
            Auth::user()->favoriteVehicles()->detach();
        } else {
            session()->forget('favorites');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'All favorites cleared successfully.',
        ]);
    }
}
