<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleModel;

class BlogController extends Controller
{
    public function getAllBlogs()
    {
        $blogs = Blog::orderBy('id', 'desc')->where('is_published', 1)->skip(1)->take(3)->get();

        return response()->json([
            'status' => 'success',
            'data' => $blogs,
        ]);
    }
    public function featuredBlog()
    {
        $featuredblog = Blog::orderBy('id', 'desc')->where('is_published', 1)->first();

        return response()->json([
            'status' => 'success',
            'data' => $featuredblog,
        ]);
    }
    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->first(['id', 'title', 'slug', 'content', 'image', 'created_at']);

        if (!$blog) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $blog,
        ]);
    }
    public function relatedBlogs($slug)
    {
        $currentBlog = Blog::where('slug', $slug)->first();

        if (!$currentBlog) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog not found.',
            ], 404);
        }

        $relatedBlogs = Blog::where('id', '!=', $currentBlog->id)
            ->orderBy('id', 'desc')
            ->take(3)
            ->get(['id', 'title', 'slug', 'image', 'created_at']);

        return response()->json([
            'status' => 'success',
            'data' => $relatedBlogs,
        ]);
    }
}
