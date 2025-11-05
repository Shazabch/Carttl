<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\Feature;
use App\Models\FuelType;
use App\Models\Transmission;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleManagementController extends Controller
{
    public function getBodyTypes()
    {
        $bodyTypes = BodyType::all();

        return response()->json([
            'status' => 'success',
            'data' => $bodyTypes,
        ]);
    }

    public function getFuelTypes()
    {
        $fuelTypes = FuelType::all();

        return response()->json([
            'status' => 'success',
            'data' => $fuelTypes,
        ]);
    }

    public function getTransmissions()
    {
        $transmissions = Transmission::all();

        return response()->json([
            'status' => 'success',
            'data' => $transmissions,
        ]);
    }

    public function getAllFeatures()
    {
        $features = Feature::where('type', 'simple')->get();

        return response()->json([
            'status' => 'success',
            'data' => $features,
        ]);
    }

    public function getExteriorFeatures()
    {
        $features = Feature::where('type', 'exterior')->get();

        return response()->json([
            'status' => 'success',
            'data' => $features,
        ]);
    }

    public function getInteriorFeatures()
    {
        $features = Feature::where('type', 'interior')->get();

        return response()->json([
            'status' => 'success',
            'data' => $features,
        ]);
    }

    public function getTags()
    {
        $tags = Feature::where('type', 'tag')->get();

        return response()->json([
            'status' => 'success',
            'data' => $tags,
        ]);
    }


    public function index(Request $request)
    {
        $type = $request->get('type', 'all'); // 'sold', 'listed', 'pending', 'draft', or 'all'
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $query = Vehicle::query();


        if ($type === 'sold') {
            $query->where('status', 'sold');
        } elseif ($type === 'listed') {
            $query->where('status', 'published');
        } elseif ($type === 'pending') {
            $query->where('status', 'pending');
        } elseif ($type === 'draft') {
            $query->where('status', 'draft');
        }


        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('vin', 'like', "%{$search}%");
            });
        }


        $vehicles = $query->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $vehicles
        ]);
    }
    public function auctions(Request $request)
    {
        $type = $request->get('type', 'all');
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $query = Vehicle::query();
        $query->where('is_auction', true);

        if ($type === 'sold') {
            $query->where('status', 'sold');
        } elseif ($type === 'listed') {
            $query->where('status', 'published');
        } elseif ($type === 'pending') {
            $query->where('status', 'pending');
        } elseif ($type === 'draft') {
            $query->where('status', 'draft');
        }


        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('vin', 'like', "%{$search}%");
            });
        }


        $vehicles = $query->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $vehicles
        ]);
    }


    public function show($id)
    {
        $vehicle = Vehicle::with(['brand:id,name', 'images:id,vehicle_id,path,is_cover', 'features', 'latestBid', 'bids', 'coverImage:id,vehicle_id,path', 'vehicleModel', 'fuelType', 'transmission', 'bodyType'])
            ->find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $vehicle
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'year' => 'required',
            'price' => 'required|numeric',
            'mileage' => 'required|numeric',
            'transmission_id' => 'required|exists:transmissions,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'body_type_id' => 'required|exists:body_types,id',
            'condition' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'variant' => 'nullable|string',
            'engine_cc' => 'nullable|string',
            'horsepower' => 'nullable|string',
            'torque' => 'nullable|string',
            'seats' => 'nullable|integer',
            'doors' => 'nullable|integer',
            'color' => 'nullable|string',
            'interior_color' => 'nullable|string',
            'drive_type' => 'nullable|string',
            'vin' => 'nullable|string',
            'registration_no' => 'nullable|string',
            'negotiable' => 'boolean',
            'is_featured' => 'boolean',
            'is_auction' => 'boolean',
            'features' => 'nullable|array',
            'images.*' => 'nullable|file|image'
        ];

        $validated = $request->validate($rules);


        $features = $validated['features'] ?? [];
        unset($validated['features'], $validated['images']);


        $validated['slug'] = Str::slug(
            $validated['title'] . ' ' . ($validated['year'] ?? '') . ' ' . ($validated['variant'] ?? '')
        );


        $vehicle = Vehicle::create($request->except(['images', 'features']));


        if (!empty($features)) {
            $vehicle->features()->sync($features);
        }



        if ($request->hasFile('images')) {
            foreach ($vehicle->images as $oldImage) {
                if ($oldImage->path) {
                    $relativePath = str_replace(asset('storage') . '/', '', $oldImage->path);
                    Storage::disk('public')->delete($relativePath);
                }
                $oldImage->delete();
            }
            foreach ($request->file('images') as $image) {
                $storedPath = $image->store('vehicle_images', 'public');
                $fullUrl = asset('storage/' . $storedPath);
                $vehicle->images()->create(['path' => $fullUrl]);
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle created successfully',
            'data' => $vehicle->load('brand', 'vehicleModel', 'features', 'images')
        ]);
    }


    public function addImages(Request $request, $vehicleId)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);

        $validated = $request->validate([
            'image_ids'     => 'nullable|array',
            'image_ids.*'   => 'integer|exists:vehicle_images,id',
            'images'        => 'nullable|array',
            'images.*'      => 'file|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp,image/bmp,image/svg+xml,image/x-icon,image/tiff,image/heic,image/heif,image/avif',
            'is_cover'      => 'nullable|array',
            'is_cover.*'    => 'boolean',
        ]);

        $existingImages = $vehicle->images; 
        $keepIds = $validated['image_ids'] ?? [];

       
        $deleteImages = $existingImages->whereNotIn('id', $keepIds);
        foreach ($deleteImages as $image) {
            // extract relative path if stored as full URL
            $path = str_replace(asset('storage/') . '/', '', $image->path);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $image->delete();
        }

        $uploaded = [];
        $sortOrder = 1;

        // Update kept images
        foreach ($keepIds as $index => $id) {
            $img = $vehicle->images()->find($id);
            if ($img) {
                $img->update([
                    'sort_order' => $sortOrder++,
                    'is_cover'   => $request->is_cover[$index] ?? $img->is_cover,
                ]);

                $uploaded[] = [
                    'id'         => $img->id,
                    'url'        => $img->path,
                    'is_cover'   => $img->is_cover,
                    'sort_order' => $img->sort_order,
                ];
            }
        }

        // Add new uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('vehicle_images', 'public');
                $fullUrl = asset('storage/' . $path);

                $newImage = $vehicle->images()->create([
                    'path'       => $fullUrl,
                    'is_cover'   => $request->is_cover[$index] ?? false,
                    'sort_order' => $sortOrder++,
                ]);

                $uploaded[] = [
                    'id'         => $newImage->id,
                    'url'        => $newImage->path,
                    'is_cover'   => $newImage->is_cover,
                    'sort_order' => $newImage->sort_order,
                ];
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Images updated successfully — old removed, kept retained, and new added.',
            'data'    => $uploaded,
        ], 200);
    }



    public function removeImages(Request $request)
    {
        $validated = $request->validate([
            'image_ids' => 'required|array|min:1',
            'image_ids.*' => 'integer|exists:vehicle_images,id',
        ]);

        $images = VehicleImage::whereIn('id', $validated['image_ids'])->get();

        foreach ($images as $image) {
            if ($image->path) {
                $relativePath = str_replace(asset('storage') . '/', '', $image->path);
                Storage::disk('public')->delete($relativePath);
            }
            $image->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => count($images) . ' images deleted successfully.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $rules = [
            'title' => 'sometimes|required|string|max:255',
            'brand_id' => 'sometimes|required|exists:brands,id',
            'vehicle_model_id' => 'sometimes|required|exists:vehicle_models,id',
            'year' => 'sometimes|required',
            'price' => 'sometimes|required|numeric',
            'mileage' => 'sometimes|required|numeric',
            'transmission_id' => 'sometimes|required|exists:transmissions,id',
            'fuel_type_id' => 'sometimes|required|exists:fuel_types,id',
            'body_type_id' => 'sometimes|required|exists:body_types,id',
            'condition' => 'sometimes|required|string',
            'status' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'variant' => 'nullable|string',
            'engine_cc' => 'nullable|string',
            'horsepower' => 'nullable|string',
            'torque' => 'nullable|string',
            'seats' => 'nullable|integer',
            'doors' => 'nullable|integer',
            'color' => 'nullable|string',
            'interior_color' => 'nullable|string',
            'drive_type' => 'nullable|string',
            'vin' => 'nullable|string',
            'registration_no' => 'nullable|string',
            'negotiable' => 'boolean',
            'is_featured' => 'boolean',
            'is_auction' => 'boolean',
            'features' => 'nullable|array',
             'images.*'=> 'file|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp,image/bmp,image/svg+xml,image/x-icon,image/tiff,image/heic,image/heif,image/avif',
        ];

        $validated = $request->validate($rules);


        $features = $validated['features'] ?? [];
        unset($validated['features'], $validated['images']);


        $vehicle->update($validated);
        $vehicle->update($request->except(['images', 'features']));


        if (!empty($features)) {
            $vehicle->features()->sync($features);
        }


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicle_images', 'public');
                $vehicle->images()->create(['path' => $path]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle updated successfully',
            'data' => $vehicle->load('brand', 'vehicleModel', 'features', 'images')
        ]);
    }




    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found.'
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle deleted successfully.'
        ]);
    }
}
