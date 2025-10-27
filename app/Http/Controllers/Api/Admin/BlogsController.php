<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
   
    public function index(Request $request)
    {
        $query = Blog::query();

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $blogs = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'status' => 'success',
            'data' => $blogs
        ]);
    }

  
    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['status' => 'error', 'message' => 'Blog not found.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $blog
        ]);
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image',
            'is_published' => 'boolean'
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        if ($request->hasFile('image')) {
           $path = $request->file('image')->store('blog-images', 'public');
           $validated['image'] = asset('storage/' . $path); // full URL
        }

        $blog = Blog::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog created successfully.',
            'data' => $blog
        ]);
    }

   
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['status' => 'error', 'message' => 'Blog not found.'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image',
            'is_published' => 'boolean'
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
           $path = $request->file('image')->store('blog-images', 'public');
           $validated['image'] = asset('storage/' . $path); 
        }

        $blog->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog updated successfully.',
            'data' => $blog
        ]);
    }

   
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['status' => 'error', 'message' => 'Blog not found.'], 404);
        }

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog deleted successfully.'
        ]);
    }
}
