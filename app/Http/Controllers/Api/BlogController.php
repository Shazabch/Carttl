<?php

namespace App\Http\Controllers\Api;

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
        $blogs = Blog::orderBy('id', 'desc')->where('is_published',1)->skip(1)->take(3)->get();

        return response()->json([
            'status' => 'success',
            'data' => $blogs,
        ]);
    }
     public function featuredBlog()
    {
        $featuredblog = Blog::orderBy('id', 'desc')->where('is_published',1)->first();

        return response()->json([
            'status' => 'success',
            'data' => $featuredblog,
        ]);
    }
  
}
