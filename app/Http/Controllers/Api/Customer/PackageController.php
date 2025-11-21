<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    // Fetch all packages
    public function index()
    {
        $packages = Package::all();
        return response()->json([
            'status' => 'success',
            'data' => $packages
        ]);
    }

    // Fetch a single package by id
    public function show($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json([
                'status' => 'error',
                'message' => 'Package not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $package
        ]);
    }
}
