<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\Feature;
use App\Models\FuelType;
use App\Models\Transmission;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\UserPreference;
use App\Services\ImageWatermarkService;
use App\Services\FCMService;
use Carbon\Carbon;
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
        $user = auth('api')->user();

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

        // If logged-in user is an agent, filter to show only vehicles with bids from their customers
        if ($user && $user->hasRole('agent')) {
            $query->whereHas('bids', function ($q) use ($user) {
                $q->whereHas('user', function ($inner) use ($user) {
                    $inner->where('agent_id', $user->id);
                });
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('vin', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($b) use ($search) {
                        $b->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicleModel', function ($m) use ($search) {
                        $m->where('name', 'like', "%{$search}%");
                    });
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

    public function auctionForDropdown()
    {
        $search = request()->get('search', '');
        $vehicles = Vehicle::where('is_auction', true)
            ->where('status', 'published')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('vin', 'like', "%{$search}%")
                        ->orWhereHas('brand', function ($b) use ($search) {
                            $b->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('vehicleModel', function ($m) use ($search) {
                            $m->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $vehicles
        ]);
    }
    public function auctions(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');
        $user = auth('api')->user();

        $query = Vehicle::where('is_auction', true)
            ->where('status', 'published'); // only published

        // If logged-in user is an agent, filter to show only vehicles with bids from their customers
        if ($user && $user->hasRole('agent')) {
            $query->whereHas('bids', function ($q) use ($user) {
                $q->whereHas('user', function ($inner) use ($user) {
                    $inner->where('agent_id', $user->id);
                });
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('vin', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($b) use ($search) {
                        $b->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicleModel', function ($m) use ($search) {
                        $m->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $vehicles = $query->with(['brand:id,name', 'vehicleModel:id,name'])
            ->withCount('bids')       // <-- Add this line
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data'   => $vehicles
        ]);
    }



    public function upcomingAuctions(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');

        $today = Carbon::now();
        $nextWeek = Carbon::now()->addDays(7);

        $query = Vehicle::where('is_auction', true)
            ->where('status', 'published')
            ->whereBetween('auction_start_date', [$today, $nextWeek]); // upcoming 7 days


        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('vin', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($b) use ($search) {
                        $b->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicleModel', function ($m) use ($search) {
                        $m->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $vehicles = $query->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('auction_start_date', 'asc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data'   => $vehicles
        ]);
    }



    public function liveAuctions(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');
        $user = auth('api')->user();

        $now = Carbon::now();

        $query = Vehicle::where('is_auction', true)
            ->where('status', 'published')
            ->where('auction_start_date', '<=', $now)
            ->where('auction_end_date', '>=', $now);

        // If logged-in user is an agent, filter to show only vehicles with bids from their customers
        if ($user && $user->hasRole('agent')) {
            $query->whereHas('bids', function ($q) use ($user) {
                $q->whereHas('user', function ($inner) use ($user) {
                    $inner->where('agent_id', $user->id);
                });
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('vin', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($b) use ($search) {
                        $b->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicleModel', function ($m) use ($search) {
                        $m->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $vehicles = $query->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('auction_end_date', 'asc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data'   => $vehicles
        ]);
    }


    public function expiredAuctions(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search', '');
        $user = auth('api')->user();

        $query = Vehicle::where('is_auction', false)
            ->where('status', 'published');
        
        // If logged-in user is an agent, filter to show only vehicles with bids from their customers
        if ($user && $user->hasRole('agent')) {
            $query->whereHas('bids', function ($q) use ($user) {
                $q->whereHas('user', function ($inner) use ($user) {
                    $inner->where('agent_id', $user->id);
                });
            });
        }
        
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('vin', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($b) use ($search) {
                        $b->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicleModel', function ($m) use ($search) {
                        $m->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $vehicles = $query->with(['brand:id,name', 'vehicleModel:id,name'])
            ->orderBy('auction_end_date', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data'   => $vehicles
        ]);
    }



    public function show($id)
    {
        $vehicle = Vehicle::with([
            'brand:id,name',
            'images:id,vehicle_id,path,is_cover',
            'features',
            'latestBid',
            'bids',
            'bids.user:id,name,email',
            'coverImage:id,vehicle_id,path',
            'vehicleModel',
            'fuelType',
            'transmission',
            'bodyType',

            // Only inspections + brand + model
            'inspections:id,vehicle_id,make,model,inspector_id,created_at',
            'inspections.brand:id,name',
            'inspections.vehicleModel:id,name',
            
            
        ])
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
            'bid_control' => 'nullable|integer',
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

        // Send notifications to users based on their preferences
        $this->sendNotificationsByPreferences($vehicle);

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle created successfully',
            'data' => $vehicle->load('brand', 'vehicleModel', 'features', 'images')
        ]);
    }

    /**
     * Send notifications to users whose preferences match the vehicle
     */
    private function sendNotificationsByPreferences(Vehicle $vehicle)
    {
        try {
            $fcm = app(FCMService::class);
            $brand = $vehicle->brand;
            $model = $vehicle->vehicleModel;

            // Build vehicle criteria
            $vehicleData = [
                'title' => $vehicle->title,
                'price' => $vehicle->price,
                'mileage' => $vehicle->mileage,
                'year' => $vehicle->year,
                'make' => $brand ? $brand->name : null,
                'model' => $model ? $model->name : null,
            ];

            // Find matching preferences
            $query = UserPreference::where('is_active', true);

            // Filter by price range
            $query->where(function($q) use ($vehicle) {
                $q->whereNull('price_from')
                  ->orWhere('price_from', '<=', $vehicle->price);
            })->where(function($q) use ($vehicle) {
                $q->whereNull('price_to')
                  ->orWhere('price_to', '>=', $vehicle->price);
            });

            // Filter by mileage range
            if ($vehicle->mileage) {
                $query->where(function($q) use ($vehicle) {
                    $q->whereNull('mileage_form')
                      ->orWhere('mileage_form', '<=', $vehicle->mileage);
                })->where(function($q) use ($vehicle) {
                    $q->whereNull('mileage_to')
                      ->orWhere('mileage_to', '>=', $vehicle->mileage);
                });
            }

            // Filter by year range
            if ($vehicle->year) {
                $query->where(function($q) use ($vehicle) {
                    $q->whereNull('year_form')
                      ->orWhere('year_form', '<=', $vehicle->year);
                })->where(function($q) use ($vehicle) {
                    $q->whereNull('year_to')
                      ->orWhere('year_to', '>=', $vehicle->year);
                });
            }

            // Filter by make
            if ($vehicle->brand) {
                $query->where(function($q) use ($vehicle) {
                    $q->whereNull('make')
                      ->orWhere('make', $vehicle->brand->name);
                });
            }

            // Filter by model
            if ($vehicle->vehicleModel) {
                $query->where(function($q) use ($vehicle) {
                    $q->whereNull('model')
                      ->orWhere('model', $vehicle->vehicleModel->name);
                });
            }

            // Filter by body type
            if ($vehicle->bodyType) {
                $query->where(function($q) use ($vehicle) {
                    $q->whereNull('body_type')
                      ->orWhere('body_type', $vehicle->bodyType->name);
                });
            }

            $matchingPreferences = $query->get();

            if ($matchingPreferences->isEmpty()) {
                return;
            }

            // Get user IDs with device tokens
            $userIds = $matchingPreferences->pluck('user_id')->filter()->unique();
            
            $deviceTokens = \App\Models\DeviceToken::whereIn('user_id', $userIds)
                ->pluck('device_token', 'user_id')
                ->toArray();

            if (empty($deviceTokens)) {
                return;
            }

            // Prepare notification
            $title = 'New Vehicle Available';
            $body = "{$vehicle->title} - Rs. " . number_format($vehicle->price);
            $data = [
                'vehicle_id' => $vehicle->id,
                'price' => $vehicle->price,
                'mileage' => $vehicle->mileage,
                'make' => $vehicle->brand ? $vehicle->brand->name : '',
                'model' => $vehicle->vehicleModel ? $vehicle->vehicleModel->name : '',
                'year' => $vehicle->year
            ];

            // Send notifications
            foreach ($deviceTokens as $token) {
                try {
                    $fcm->sendNotification($token, $title, $body, $data);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to send FCM notification: " . $e->getMessage());
                }
            }

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Error sending preference-based notifications: " . $e->getMessage());
        }
    }


    public function addImages(Request $request, $vehicleId, ImageWatermarkService $watermarkService)
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
            $path = str_replace(asset('storage/') . '/', '', $image->path);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $image->delete();
        }

        $uploaded = [];
        $sortOrder = 1;

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

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {

                // CHANGE START
                $originalPath = $file->getPathname();
                $relativePath = 'vehicle_images/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $savePath = storage_path('app/public/' . $relativePath);
                $logoPath = public_path('images/caartl.png');
                $watermarkService->addLogoWatermark($originalPath, $logoPath, $savePath, 30);
                $fullUrl = asset('storage/' . $relativePath);
                // CHANGE END

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
            'bid_control' => 'nullable|integer',
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
            'images.*' => 'file|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp,image/bmp,image/svg+xml,image/x-icon,image/tiff,image/heic,image/heif,image/avif',
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
