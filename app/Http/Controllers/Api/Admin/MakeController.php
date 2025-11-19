<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MakeController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $makes = Brand::query()->whereHas('vehicleModels')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $makes
        ]);
    }

  public function ModelsByMake($makeId, Request $request)
{
    $search = $request->input('search');

    $models = VehicleModel::where('brand_id', $makeId)
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->select('id', 'name')
        ->get();

    if ($models->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'No models found.',
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => $models,
    ]);
}


    public function show($id)
    {
        $make = Brand::find($id);

        if (!$make) {
            return response()->json([
                'status' => 'error',
                'message' => 'Make not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $make
        ]);
    }
public function addModels(Request $request, $makeId)
{
    $brand = Brand::find($makeId);

    if (!$brand) {
        return response()->json([
            'status' => 'error',
            'message' => 'Make not found.'
        ], 404);
    }

    $validated = $request->validate([
        'models' => 'required|array',
        'models.*' => 'required|string|max:255'
    ]);

    $added = [];
    $skipped = [];

    foreach ($validated['models'] as $modelName) {
        // Check for duplicate (case-insensitive)
        $exists = VehicleModel::where('brand_id', $makeId)
            ->whereRaw('LOWER(name) = ?', [strtolower($modelName)])
            ->exists();

        if ($exists) {
            $skipped[] = $modelName;
            continue;
        }

        $newModel = VehicleModel::create([
            'brand_id' => $makeId,
            'name' => $modelName,
        ]);

        $added[] = $newModel;
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Model(s) added successfully.',
        'data' => [
            'added' => $added,
            'skipped' => $skipped,
        ],
    ]);
}


   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:brands,name',
        'image_source' => 'nullable|image|max:2048',
        'models' => 'required|array',       
        'models.*' => 'required'
    ]);

   
    $path = null;
    if ($request->hasFile('image_source')) {
        $storedPath = $request->file('image_source')->store('brand-images', 'public');
        $path = asset('storage/' . $storedPath); // Store full URL
    }

    
    $brand = Brand::create([
        'name' => $validated['name'],
        'slug' => Str::slug($validated['name']),
        'image_source' => $path,
    ]);

    
    foreach ($validated['models'] as $modelName) {
        VehicleModel::create([
            'brand_id' => $brand->id,
            'name' => $modelName,
           
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Brand and models created successfully.',
        'data' => [
            'brand' => $brand,
            'models' => VehicleModel::where('brand_id', $brand->id)->get(),
        ],
    ]);
}


   public function update(Request $request, $id)
{
    $brand = Brand::find($id);

    if (!$brand) {
        return response()->json([
            'status' => 'error',
            'message' => 'Brand not found.'
        ], 404);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
        'image_source' => 'nullable|image|max:2048',
        'models' => 'nullable|array',
        'models.*' => 'required|string|max:255'
    ]);

    // Handle image upload (with full URL)
    $path = $brand->image_source;
    if ($request->hasFile('image_source')) {
        // Delete old file if it's a local storage path
        if ($brand->image_source && str_starts_with($brand->image_source, 'brand-images/')) {
            Storage::disk('public')->delete($brand->image_source);
        }

        $storedPath = $request->file('image_source')->store('brand-images', 'public');
        $path = asset('storage/' . $storedPath);
    }

    // Update brand info
    $brand->update([
        'name' => $validated['name'],
        'slug' => Str::slug($validated['name']),
        'image_source' => $path,
    ]);

   if (!empty($validated['models'])) {
    VehicleModel::where('brand_id', $brand->id)->delete();
    foreach ($validated['models'] as $modelName) {
        VehicleModel::create([
            'brand_id' => $brand->id,
            'name' => $modelName,
        ]);
    }
}


    return response()->json([
        'status' => 'success',
        'message' => 'Brand updated successfully.',
        'data' => [
            'brand' => $brand,
            'models' => VehicleModel::where('brand_id', $brand->id)->get(),
        ],
    ]);
}

    public function destroy($id)
    {
        $make = Brand::find($id);

        if (!$make) {
            return response()->json([
                'status' => 'error',
                'message' => 'Make not found.'
            ], 404);
        }

        if ($make->image_source) {
            Storage::disk('public')->delete($make->image_source);
        }

        $make->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Make deleted successfully.'
        ]);
    }
     public function deleteModel($id)
    {
        $model = VehicleModel::find($id);

        if (!$model) {
            return response()->json([
                'status' => 'error',
                'message' => 'Model not found.'
            ], 404);
        }

    
        $model->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Model deleted successfully.'
        ]);
    }
}