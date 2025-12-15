<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarDamage;
use App\Models\InspectionEnquiry;
use App\Models\VehicleDocument;
use App\Models\ReportShare;
use App\Models\VehicleInspectionImage;
use App\Models\VehicleInspectionReport;
use App\Models\InspectionField;
use App\Models\InspectionFieldImage;
use App\Notifications\VehicleInspectionConfirmation;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ImageWatermarkService;
use Illuminate\Support\Facades\Crypt;

class InspectionReportController extends Controller
{

    
public function index(Request $request)
{
    $query = VehicleInspectionReport::with([
        'brand:id,name',
        'vehicleModel:id,name',
    ]);

    // --- Filters ---

    if ($request->filled('inspection_enquiry_id')) {
        $query->where('inspection_enquiry_id', $request->inspection_enquiry_id);
    }

    if ($request->filled('vehicle_id')) {
        $query->where('vehicle_id', $request->vehicle_id);
    }

    // 🔍 Search
    if ($request->filled('search')) {
        $s = $request->search;
        $query->where(function ($q) use ($s) {
            $q->where('vin', 'like', "%{$s}%")
                ->orWhereHas('brand', fn ($b) =>
                    $b->where('name', 'like', "%{$s}%")
                )
                ->orWhereHas('vehicleModel', fn ($m) =>
                    $m->where('name', 'like', "%{$s}%")
                );
        });
    }

    // 📅 DATE filter (YYYY-MM-DD)
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // 📆 MONTH filter
    // Accepts: "2025-12" OR "12"
    if ($request->filled('month')) {
        if (strlen($request->month) === 7) {
            // YYYY-MM
            $query->whereYear('created_at', substr($request->month, 0, 4))
                  ->whereMonth('created_at', substr($request->month, 5, 2));
        } else {
            // MM only
            $query->whereMonth('created_at', $request->month);
        }
    }

    // --- Pagination ---
    $perPage = $request->get('per_page', 10);
    $reports = $query->latest()->paginate($perPage);

    // --- Transform ---
    $reports->getCollection()->transform(function ($report) {
        $report->make_name  = $report->brand->name ?? null;
        $report->model_name = $report->vehicleModel->name ?? null;

        unset($report->brand, $report->vehicleModel);

        return $report;
    });

    return response()->json([
        'status' => 'success',
        'data'   => $reports,
    ]);
}
    public function getFieldImages($reportId, $field)
    {
        $fieldData = InspectionField::with('files')
            ->where('vehicle_inspection_report_id', $reportId)
            ->where('name', $field)
            ->first();

        if (!$fieldData || $fieldData->files->isEmpty()) {
            return response()->json(['images' => []]);
        }

        $files = $fieldData->files->map(function ($item) {
            $path = $item->path;
            $url  = str_starts_with($path, 'http') ? $path : Storage::url($path);

            $thumbUrl = null;
            if ($item->file_type === 'video') {
                $thumbPath = preg_replace('/\.[^.]+$/', '_thumb.jpg', $path);
                $thumbUrl = str_starts_with($thumbPath, 'http')
                    ? $thumbPath
                    : (Storage::exists($thumbPath) ? Storage::url($thumbPath) : null);
            }

            return [
                'path'      => $url,
                'thumb'     => $thumbUrl,
                'file_type' => $item->file_type,
            ];
        })->toArray();

        return response()->json(['images' => $files]);
    }

    public function show($id)
    {
        $report = VehicleInspectionReport::with([
            'vehicle',
            'damages',
            'inspector',
            'images',
            'brand:id,name',
            'vehicleModel:id,name',
            'fields.files'
        ])->findOrFail($id);

        $report->make_name = $report->brand->name ?? null;
        $report->model_name = $report->vehicleModel->name ?? null;

        unset($report->brand, $report->vehicleModel);

        return response()->json([
            'status' => 'success',
            'data'   => $report,
        ]);
    }

    

    public function showShared($uuid)
    {
        try {
            $share = ReportShare::findOrFail($uuid);

            if ($share->expires_at && now()->gt($share->expires_at)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Link has expired'
                ], 410);
            }

            $decrypted = Crypt::decrypt($share->token);
            $reportId = $decrypted['report_id'];

            $report = \App\Models\VehicleInspectionReport::with([
                'vehicle',
                'brand',
                'vehicleModel',
                'damages',
                'images',
                'inspector',
                'fields.files'
            ])->findOrFail($reportId);
            $report->make_name = $report->brand->name ?? null;
            $report->model_name = $report->vehicleModel->name ?? null;
            unset($report->brand, $report->vehicleModel);

            return response()->json([
                'success' => true,
                'data' => $report
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid link'
            ], 401);
        }
    }

    public function generateShareableLink(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:vehicle_inspection_reports,id',
            'expires_at' => 'required|date|after:now'
        ]);

        $payload = [
            'report_id' => $request->report_id,
            'expires_at' => $request->expires_at,
            'created_at' => now()
        ];

        $token = Crypt::encrypt($payload);
        $uuid = Str::uuid()->toString();

        // Store in DB using model
        ReportShare::create([
            'id' => $uuid,
            'report_id' => $request->report_id,
            'token' => $token,
            'expires_at' => $request->expires_at,
        ]);

        $frontendUrl = (env('APP_ENV') === 'production')
            ? config('app.frontend_url_live')
            : config('app.frontend_url_local');

        $frontendUrl .= '/shared/' . $uuid;

        return response()->json([
            'success' => true,
            'shareable_url' => $frontendUrl,
            'expires_at' => $request->expires_at
        ]);
    }


    public function store(Request $request)
    {

        $rules = [
            'vehicle_id'             => 'nullable|exists:vehicles,id',
            'inspection_enquiry_id'  => 'nullable|exists:inspection_enquiries,id',
            'make'                   => 'required',
            'model'                  => 'required',
            'year'                   => 'required|integer',
            'vin'                    => 'nullable|string',
            'engine_cc'              => 'nullable|string',
            'horsepower'             => 'nullable|string',
            'noOfCylinders'          => 'nullable|integer',
            'transmission'           => 'nullable|string',
            'color'                  => 'nullable|string',
            'body_type'              => 'nullable|string',
            'specs'                  => 'nullable|string',
            'odometer'               => 'nullable|numeric',
            'notes'                  => 'nullable|string',
            'damage_image'           => 'nullable|file|image',
        ];

        $validated = $request->validate($rules);


        $reportData = $request->except(['damage_image']);
        $report = VehicleInspectionReport::create($reportData);




        if ($request->hasFile('damage_image')) {
            $file   = $request->file('damage_image');
            $dir = 'damage-assessments';
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            $filename = 'damage-image-' . $report->id . '-' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();
            $path = $dir . '/' . $filename;

            Storage::disk('public')->putFileAs($dir, $file, $filename);
            $fullUrl = asset('storage/' . $path);


            if ($report->vehicle_id) {
                VehicleDocument::create([
                    'vehicle_id' => $report->vehicle_id,
                    'file_path'  => $fullUrl,
                    'type'       => 'InspectionReportImage',
                ]);
            }

            $report->update(['damage_file_path' => $fullUrl]);
        }


        $this->generatePdf($report->id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Report created successfully',
            'data'    => $report,
        ], 201);
    }

    public function storeVehicleImages(Request $request, ImageWatermarkService $watermarkService)
    {
        $validated = $request->validate([
            'vehicle_inspection_report_id' => 'required|exists:vehicle_inspection_reports,id',
            'image_ids'                    => 'nullable|array',
            'image_ids.*'                  => 'integer|exists:vehicle_inspection_images,id',
            'images'                       => 'nullable|array',
            'images.*'                     => 'file|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp,image/bmp,image/svg+xml,image/x-icon,image/tiff,image/heic,image/heif,image/avif',
            'is_cover'                     => 'nullable|array',
            'is_cover.*'                   => 'boolean',
        ]);

        $reportId = $validated['vehicle_inspection_report_id'];

        // Delete images not in keepIds
        $existingImages = VehicleInspectionImage::where('vehicle_inspection_report_id', $reportId)->get();
        $keepIds = $validated['image_ids'] ?? [];
        $deleteImages = $existingImages->whereNotIn('id', $keepIds);

        foreach ($deleteImages as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }

        $uploaded = [];
        $sortOrder = 1;

        // Update existing images
        foreach ($keepIds as $index => $id) {
            $img = VehicleInspectionImage::find($id);
            if ($img) {
                $img->update([
                    'sort_order' => $sortOrder++,
                    'is_cover'   => $request->is_cover[$index] ?? $img->is_cover,
                ]);

                $uploaded[] = [
                    'id'         => $img->id,
                    'url'        => asset('storage/' . $img->path),
                    'is_cover'   => $img->is_cover,
                    'sort_order' => $img->sort_order,
                ];
            }
        }

        // Process newly uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $originalPath = $file->getPathname();
                $path = 'inspection_images/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $savePath = storage_path('app/public/' . $path);

                // Add watermark
                $logoPath = public_path('images/caartl.png'); // your watermark logo
                $watermarkService->addLogoWatermark($originalPath, $logoPath, $savePath, 30);

                // Save record in DB
                $newImage = VehicleInspectionImage::create([
                    'vehicle_inspection_report_id' => $reportId,
                    'path'                         => $path,
                    'is_cover'                     => $request->is_cover[$index] ?? false,
                    'sort_order'                   => $sortOrder++,
                ]);

                $uploaded[] = [
                    'id'         => $newImage->id,
                    'url'        => asset('storage/' . $path),
                    'is_cover'   => $newImage->is_cover,
                    'sort_order' => $newImage->sort_order,
                ];
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Images updated successfully — old removed, kept retained, and new added with watermark.',
            'data'    => $uploaded,
        ], 200);
    }



    public function storeVehicleImagesCopy(Request $request, ImageWatermarkService $watermarkService)
    {
        $images = $request->file('images');

        foreach ($images as $imageFile) {
            $originalPath = $imageFile->getPathname();
            $logoPath = public_path('images/caartl.png'); // your watermark logo
            $savePath = public_path('uploads/' . $imageFile->getClientOriginalName());

            $watermarkService->addLogoWatermark($originalPath, $logoPath, $savePath, 30);
        }

        return response()->json([
            'message' => 'Images uploaded and watermarked successfully.'
        ]);
    }



    public function removeVehicleImages(Request $request)
    {
        $validated = $request->validate([
            'image_ids' => 'required|array|min:1',
            'image_ids.*' => 'integer|exists:vehicle_inspection_images,id',
        ]);

        $removed = [];

        foreach ($validated['image_ids'] as $id) {
            $image = VehicleInspectionImage::find($id);

            if ($image) {

                if (!empty($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }


                $image->delete();

                $removed[] = $id;
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Selected inspection images removed successfully.',
            'removed' => $removed,
        ], 200);
    }

    public function storeInspectionFields(Request $request)
    {
        $validated = $request->validate([
            'vehicle_inspection_report_id' => 'required|exists:vehicle_inspection_reports,id',
            'inspection_image_fields'      => 'required|array',
        ]);

        $reportId = $validated['vehicle_inspection_report_id'];
        $responseData = [];

        foreach ($request->inspection_image_fields as $fieldName => $files) {

            $field = InspectionField::updateOrCreate(
                [
                    'vehicle_inspection_report_id' => $reportId,
                    'name' => $fieldName,
                ],
                []
            );

            $savedFiles = [];

            if (!empty($files)) {

                foreach ($files as $file) {

                    if ($file instanceof \Illuminate\Http\UploadedFile) {

                        $mime = $file->getMimeType();

                        // Detect file type
                        $isImage = str_starts_with($mime, 'image/');
                        $isVideo = str_starts_with($mime, 'video/');

                        // Allow only images or videos
                        if (!($isImage || $isVideo)) {
                            continue;
                        }

                        // Store in same folder
                        $path = $file->store('inspection_field_files', 'public');

                        $fileType = $isImage ? 'image' : 'video';

                        $fullPath = asset('storage/' . $path);

                        $savedFiles[] = InspectionFieldImage::create([
                            'inspection_field_id' => $field->id,
                            'path'               => $fullPath,
                            'file_type'          => $fileType,
                        ]);
                    }
                }
            }

            $responseData[] = [
                'field' => $field,
                'files' => $savedFiles,
            ];
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Fields, images, and videos saved successfully.',
            'data'    => $responseData,
        ]);
    }



    public function removeInspectionFieldImages(Request $request)
    {
        $validated = $request->validate([
            'inspection_image_fields' => 'required|array',
            'inspection_image_fields.*' => 'array',
            'inspection_image_fields.*.*' => 'integer|exists:inspection_field_images,id',
        ]);

        $removed = [];

        foreach ($validated['inspection_image_fields'] as $fieldName => $imageIds) {
            foreach ($imageIds as $imageId) {
                $image = InspectionFieldImage::find($imageId);

                if ($image) {
                    $relativePath = str_replace(asset('storage/'), '', $image->path);
                    Storage::disk('public')->delete($relativePath);
                    $image->delete();

                    $removed[] = [
                        'field_name' => $fieldName,
                        'image_id'   => $imageId,
                    ];
                }
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Selected inspection field images removed successfully.',
            'removed' => $removed,
        ]);
    }

    public function update(Request $request, $id)
    {
        $report = VehicleInspectionReport::findOrFail($id);

        $rules = [
            'vehicle_id'             => 'nullable|exists:vehicles,id',
            'inspection_enquiry_id'  => 'nullable|exists:inspection_enquiries,id',
            'make'                   => 'required',
            'model'                  => 'required',
            'year'                   => 'required|integer',
            'vin'                    => 'nullable|string',
            'engine_cc'              => 'nullable|string',
            'horsepower'             => 'nullable|string',
            'noOfCylinders'          => 'nullable|integer',
            'transmission'           => 'nullable|string',
            'color'                  => 'nullable|string',
            'body_type'              => 'nullable|string',
            'specs'                  => 'nullable|string',
            'odometer'               => 'nullable|numeric',
            'notes'                  => 'nullable|string',
            'damage_image'           => 'nullable|file|image',
        ];

        $validated = $request->validate($rules);


        $updateData = $request->except(['damage_image']);
        $report->update($updateData);




        if ($request->hasFile('damage_image')) {
            $file = $request->file('damage_image');
            $dir = 'damage-assessments';

            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            if ($report->damage_file_path) {
                $oldPath = str_replace(asset('storage/'), '', $report->damage_file_path);
                Storage::disk('public')->delete($oldPath);
            }

            $filename = 'damage-image-' . $report->id . '-' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();
            $path = $dir . '/' . $filename;

            Storage::disk('public')->putFileAs($dir, $file, $filename);
            $fullUrl = asset('storage/' . $path);

            if ($report->vehicle_id) {
                VehicleDocument::create([
                    'vehicle_id' => $report->vehicle_id,
                    'file_path'  => $fullUrl,
                    'type'       => 'InspectionReportImage',
                ]);
            }

            $report->update(['damage_file_path' => $fullUrl]);
        }


        $this->generatePdf($report->id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Report updated successfully',
            'data'    => $report,
        ]);
    }

    // damage report
    public function getDamageTypes()
    {
        $damageTypes = [
            'a' => ['name' => 'Scratch', 'color' => '#FFC0CB'],          // Pink
            'b' => ['name' => 'Multiple Scratches', 'color' => '#FFFF00'], // Yellow
            'c' => ['name' => 'Cosmetic Paint', 'color' => '#008000'],    // Green
            'd' => ['name' => 'Chip', 'color' => '#00AA00'],              // unchanged
            'e' => ['name' => 'Dent', 'color' => '#0000FF'],             // Blue
            'f' => ['name' => 'Repainted', 'color' => '#FF0000'],        // Red
            'g' => ['name' => 'Repaired', 'color' => '#800080'],         // Purple
            'h' => ['name' => 'Foiled Wrap', 'color' => '#FFA500'],      // Orange
            'i' => ['name' => 'Full PPF', 'color' => '#d80881ff'],       // unchanged
            'j' => ['name' => 'Rust', 'color' => '#6b5407ff'],           // unchanged
        ];

        $formatted = collect($damageTypes)->map(function ($item, $key) {
            return [
                'type'  => $key,
                'name'  => $item['name'],
                'color' => $item['color'],
            ];
        })->values();

        return response()->json([
            'status'  => 'success',
            'message' => 'Damage types fetched successfully.',
            'data'    => $formatted,
        ]);
    }


    public function addDamage(Request $request)
    {
        $validated = $request->validate([
            'inspection_id'       => 'required|exists:vehicle_inspection_reports,id',
            'damages'             => 'required|array|min:1',
            'damages.*.type'      => 'required|string|max:255',
            'damages.*.body_part' => 'required|string|max:255',
            'damages.*.severity'  => 'required|string|max:100',
            'damages.*.x'         => 'required|numeric',
            'damages.*.y'         => 'required|numeric',
            'damages.*.remark'    => 'nullable|string',
            'damage_image'        => 'nullable|file',
        ]);

        $inspection = VehicleInspectionReport::findOrFail($validated['inspection_id']);

        CarDamage::where('inspection_id', $inspection->id)->delete();
        $savedDamages = [];
        foreach ($validated['damages'] as $damageData) {
            $damage = CarDamage::create([
                'inspection_id' => $inspection->id,
                'type'          => $damageData['type'],
                'body_part'     => $damageData['body_part'],
                'severity'      => $damageData['severity'],
                'x'             => $damageData['x'],
                'y'             => $damageData['y'],
                'remark'        => $damageData['remark'] ?? null,
            ]);

            $savedDamages[] = $damage;
        }


        if ($request->hasFile('damage_image')) {
            $dir = 'damage-assessments';

            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }

            if ($inspection->damage_file_path) {
                $oldPath = str_replace(asset('storage/'), '', $inspection->damage_file_path);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $file = $request->file('damage_image');
            $filename = 'damage-image-' . $inspection->id . '-' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();
            $path = $dir . '/' . $filename;

            Storage::disk('public')->putFileAs($dir, $file, $filename);
            $fullUrl = asset('storage/' . $path);

            if ($inspection->vehicle_id) {
                VehicleDocument::create([
                    'vehicle_id' => $inspection->vehicle_id,
                    'file_path'  => $fullUrl,
                    'type'       => 'InspectionReportImage',
                ]);
            }


            $inspection->update(['damage_file_path' => $fullUrl]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Damages and image saved successfully.',
            'data'    => $savedDamages,
        ], 201);
    }

    public function removeDamage(Request $request)
    {
        $validated = $request->validate([
            'damage_ids'   => 'required|array|min:1',
            'damage_ids.*' => 'integer|exists:car_damages,id',
        ]);

        $deletedCount = CarDamage::whereIn('id', $validated['damage_ids'])->delete();

        return response()->json([
            'status'  => 'success',
            'message' => "{$deletedCount} damage record(s) removed successfully.",
            'deleted_ids' => $validated['damage_ids'],
        ], 200);
    }

    public function destroy($id)
    {
        $report = VehicleInspectionReport::findOrFail($id);

        if ($report->damage_file_path && Storage::disk('public')->exists($report->damage_file_path)) {
            Storage::disk('public')->delete($report->damage_file_path);
            VehicleDocument::where('file_path', $report->damage_file_path)->delete();
        }

        if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
            Storage::disk('public')->delete($report->file_path);
            VehicleDocument::where('file_path', $report->file_path)->delete();
        }

        foreach (Storage::disk('public')->files('damage-assessments') as $path) {
            if (Str::startsWith(basename($path), 'damage-report-' . $report->id . '-')) {
                Storage::disk('public')->delete($path);
                VehicleDocument::where('file_path', $path)->delete();
            }
        }
        foreach (Storage::disk('public')->files('inspection_pdf') as $path) {
            if (Str::startsWith(basename($path), 'inspection_' . $report->id . '_')) {
                Storage::disk('public')->delete($path);
                VehicleDocument::where('file_path', $path)->delete();
            }
        }

        $report->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Report deleted successfully',
        ]);
    }

    public function share(Request $request, $id)
    {
        $request->validate([
            'expires_at' => 'nullable|date',
        ]);

        $report = VehicleInspectionReport::findOrFail($id);

        $expiry = $request->has('expires_at') ? Carbon::parse($request->expires_at) : now()->addDay();

        if ($expiry->isPast()) {
            return response()->json(['status' => 'error', 'message' => 'Expiry must be in the future'], 422);
        }

        $link = URL::temporarySignedRoute(
            'inspection.report.download.signed',
            $expiry,
            ['report' => $report->id]
        );

        $report->update([
            'shared_link'            => $link,
            'shared_link_expires_at' => $expiry,
        ]);

        if ($report->inspection_enquiry_id) {
            $enquiry = InspectionEnquiry::find($report->inspection_enquiry_id);
            if ($enquiry && $enquiry->email) {
                $user = \App\Models\User::where('email', $enquiry->email)->first();
                if ($user) {
                    Notification::send($user, new VehicleInspectionConfirmation($enquiry));
                }
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Share link generated',
            'data'    => [
                'link'       => $link,
                'expires_at' => $expiry->toDateTimeString(),
            ],
        ]);
    }

    public function generatePdf($reportId)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);

        try {
            $reportInView = VehicleInspectionReport::findOrFail($reportId);



            $damageTypes = [
                'Scratch'           => ['name' => 'Scratch',       'color' => '#FFC0CB'], // Pink
                'Multiple Scratches' => ['name' => 'Multiple Scratches', 'color' => '#FFFF00'], // Yellow
                'Cosmetic Paint'     => ['name' => 'Cosmetic Paint', 'color' => '#00AA00'], // Green
                'Chip'               => ['name' => 'Chip',          'color' => '#00AA00'], // unchanged (Green?)
                'Dent'               => ['name' => 'Dent',          'color' => '#0000FF'], // Blue
                'Repainted'          => ['name' => 'Repainted',     'color' => '#FF0000'], // Red
                'Repaired'           => ['name' => 'Repaired',      'color' => '#800080'], // Purple
                'Foiled Wrap'        => ['name' => 'Foiled Wrap',   'color' => '#FFA500'], // Orange
                'Full PPF'           => ['name' => 'Full PPF',      'color' => '#D80881'], // unchanged
                'Rust'               => ['name' => 'Rust',          'color' => '#6B5407'], // unchanged
            ];


            $damages = CarDamage::where('inspection_id', $reportInView->id)->get();

            if ($reportInView->file_path && Storage::disk('public')->exists($reportInView->file_path)) {
                Storage::disk('public')->delete($reportInView->file_path);
                VehicleDocument::where('file_path', $reportInView->file_path)->delete();
            }

            foreach (Storage::disk('public')->files('damage-assessments') as $path) {
                if (Str::startsWith(basename($path), 'damage-report-' . $reportInView->id . '-')) {
                    Storage::disk('public')->delete($path);
                    VehicleDocument::where('file_path', $path)->delete();
                }
            }

            foreach (Storage::disk('public')->files('inspection_pdf') as $path) {
                if (Str::startsWith(basename($path), 'inspection_' . $reportInView->id . '_')) {
                    Storage::disk('public')->delete($path);
                    VehicleDocument::where('file_path', $path)->delete();
                }
            }

            $damageAssessmentImage = $reportInView->damage_file_path
                ? asset('storage/' . $reportInView->damage_file_path)
                : null;

            $directory = 'inspection_pdf';
            if (! Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $html = view('pdf.inspection.report-pdf-template', [
                'reportInView' => $reportInView,
                'damageAssessmentImage' => $damageAssessmentImage,
                'damageTypes' => $damageTypes,
                'damages' => $damages,
            ])->render();

            // ⚙️ Configure Dompdf with memory-safe options
            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4', 'portrait')
                ->setWarnings(false);

            $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
            $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
            $pdf->getDomPDF()->set_option('enable_php', true);
            $pdf->getDomPDF()->set_option('enable_font_subsetting', true);
            $pdf->getDomPDF()->set_option('isFontSubsettingEnabled', true);
            $pdf->getDomPDF()->set_option('enable_javascript', false);




            $filename = 'inspection_' . $reportInView->id . '_' . now()->format('Ymd_His') . '.pdf';
            $filepath = $directory . '/' . $filename;

            Storage::disk('public')->put($filepath, $pdf->output());

            if ($reportInView->vehicle_id) {
                VehicleDocument::create([
                    'vehicle_id' => $reportInView->vehicle_id,
                    'file_path'  => $filepath,
                    'type'       => 'InspectionReport',
                ]);
            }

            $reportInView->update(['file_path' => $filepath]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Inspection Report PDF generated successfully.',
                'data'    => [
                    'report_id' => $reportInView->id,
                    'pdf_url'   => asset('storage/' . $filepath),
                    'image_url' => $damageAssessmentImage,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to generate inspection PDF.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }



    public function downloadReport($id)
    {
        try {

            $report = VehicleInspectionReport::findOrFail($id);

            $filePath = $report->file_path;
            if (! $filePath || ! Storage::disk('public')->exists($filePath)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Inspection report file not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            $fullPath         = storage_path('app/public/' . $filePath);
            $downloadFilename = 'Inspection-Report-' . ($report->inspection->vin ?? 'UnknownVIN') . '.pdf';
            return response()->download($fullPath, $downloadFilename, [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to download report.',
                'error'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
