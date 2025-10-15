<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialsController extends Controller
{
   
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $testimonials = Testimonial::where('name', 'like', "%{$search}%")
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $testimonials,
        ]);
    }

   
    public function show($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $testimonial,
        ]);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'status' => 'boolean',
            'image_path' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('testimonial-images', 'public');
        }

        $testimonial = Testimonial::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial created successfully.',
            'data' => $testimonial,
        ]);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'status' => 'boolean',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            if ($testimonial->image_path) {
                Storage::disk('public')->delete($testimonial->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('testimonial-images', 'public');
        }

        $testimonial->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial updated successfully.',
            'data' => $testimonial,
        ]);
    }

   
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'status' => 'error',
                'message' => 'Testimonial not found.',
            ], 404);
        }

        if ($testimonial->image_path) {
            Storage::disk('public')->delete($testimonial->image_path);
        }

        $testimonial->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial deleted successfully.',
        ]);
    }

    
    public function toggleStatus($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->status = !$testimonial->status;
        $testimonial->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial status updated.',
            'data' => $testimonial,
        ]);
    }
}
