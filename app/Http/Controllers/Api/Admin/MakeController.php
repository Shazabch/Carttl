<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MakeController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $makes = Brand::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $makes
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

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'image_source' => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('image_source')) {
            $path = $request->file('image_source')->store('brand-images', 'public');
        }

        $make = Brand::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'image_source' => $path
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Make created successfully.',
            'data' => $make
        ]);
    }

   
    public function update(Request $request, $id)
    {
        $make = Brand::find($id);

        if (!$make) {
            return response()->json([
                'status' => 'error',
                'message' => 'Make not found.'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $make->id,
            'image_source' => 'nullable|image|max:2048'
        ]);

        $path = $make->image_source;
        if ($request->hasFile('image_source')) {
            if ($make->image_source) {
                Storage::disk('public')->delete($make->image_source);
            }
            $path = $request->file('image_source')->store('brand-images', 'public');
        }

        $make->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'image_source' => $path
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Make updated successfully.',
            'data' => $make
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
}
