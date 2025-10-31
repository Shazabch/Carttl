<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarDamage;
use App\Models\InspectionEnquiry;
use App\Models\VehicleDocument;
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

class InspectionReportController extends Controller
{

   public function index(Request $request)
{
    $query = VehicleInspectionReport::with([
        'brand:id,name',
        'vehicleModel:id,name',
    ]);

    // --- Filters ---
    if ($request->has('inspection_enquiry_id')) {
        $query->where('inspection_enquiry_id', $request->inspection_enquiry_id);
    }

    if ($request->has('vehicle_id')) {
        $query->where('vehicle_id', $request->vehicle_id);
    }

    if ($request->has('search')) {
        $s = $request->search;
        $query->where(function ($q) use ($s) {
            $q->where('vin', 'like', "%{$s}%")
                ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$s}%"))
                ->orWhereHas('model', fn($m) => $m->where('name', 'like', "%{$s}%"));
        });
    }

    // --- Pagination ---
    $perPage = $request->get('per_page', 10);
    $reports = $query->latest()->paginate($perPage);

   
    $reports->getCollection()->transform(function ($report) {
        $report->make_name = $report->brand->name ?? null;
        $report->model_name = $report->vehicleModel->name ?? null;

       
        unset($report->brand, $report->vehicleModel);

        return $report;
    });

    return response()->json([
        'status' => 'success',
        'data' => $reports,
    ]);
}


  public function show($id)
{
    $report = VehicleInspectionReport::with(['vehicle','damages','inspector','images', 'brand:id,name', 'vehicleModel:id,name'])
        ->findOrFail($id);

    $report->make_name = $report->brand->name ?? null;
    $report->model_name = $report->vehicleModel->name ?? null;

    unset($report->brand, $report->vehicleModel);

    return response()->json([
        'status' => 'success',
        'data'   => $report,
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


public function storeVehicleImages(Request $request)
{
    $validated = $request->validate([
        'vehicle_inspection_report_id' => 'required|exists:vehicle_inspection_reports,id',
        'image_ids'                    => 'nullable|array',        
        'image_ids.*'                  => 'integer|exists:vehicle_inspection_images,id',
        'images'                       => 'nullable|array',       
        'images.*'                     => 'file|mimes:jpg,jpeg,png,webp',
        'is_cover'                     => 'nullable|array',
        'is_cover.*'                   => 'boolean',
    ]);

    $reportId = $validated['vehicle_inspection_report_id'];

    $existingImages = VehicleInspectionImage::where('vehicle_inspection_report_id', $reportId)->get();

    $keepIds = $validated['image_ids'] ?? [];
    $deleteImages = $existingImages->whereNotIn('id', $keepIds);

    foreach ($deleteImages as $image) {
        if (\Storage::disk('public')->exists($image->path)) {
            \Storage::disk('public')->delete($image->path);
        }
        $image->delete();
    }

    $uploaded = [];
    $sortOrder = 1;

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

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('inspection_images', 'public');

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
        'message' => 'Images updated successfully — old removed, kept retained, and new added.',
        'data'    => $uploaded,
    ], 200);
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
        'inspection_image_fields' => 'required|array',
        
    ]);

    $reportId = $validated['vehicle_inspection_report_id'];

    $responseData = [];

    foreach ($request->inspection_image_fields as $fieldName => $fieldImages) {
        // Create inspection field
        $field = InspectionField::create([
            'vehicle_inspection_report_id' => $reportId,
            'name' => $fieldName,
        ]);

        $savedImages = [];

        if (!empty($fieldImages)) {
            foreach ($fieldImages as $imageFile) {
                if ($imageFile instanceof \Illuminate\Http\UploadedFile) {
                    $path = $imageFile->store('inspection_field_images', 'public');
                    $fullPath = asset('storage/' . $path);

                    $img = InspectionFieldImage::create([
                        'inspection_field_id' => $field->id,
                        'path' => $fullPath,
                    ]);

                    $savedImages[] = $img;
                }
            }
        }

        $responseData[] = [
            'field' => $field,
            'images' => $savedImages,
        ];
    }

    return response()->json([
        'status'  => 'success',
        'message' => 'Inspection fields and images saved successfully.',
        'data'    => $responseData,
    ]);
}

    public function removeInspectionFieldImages(Request $request)
{
    $validated = $request->validate([
        'inspection_image_fields' => 'required|array',
        'inspection_image_fields.*' => 'array', // e.g. inspection_image_fields[rimSize] = [1, 2, 3]
        'inspection_image_fields.*.*' => 'integer|exists:inspection_field_images,id',
    ]);

    $removed = [];

    foreach ($validated['inspection_image_fields'] as $fieldName => $imageIds) {
        foreach ($imageIds as $imageId) {
            $image = InspectionFieldImage::find($imageId);

            if ($image) {
                // Delete from storage
                $relativePath = str_replace(asset('storage/'), '', $image->path);
                Storage::disk('public')->delete($relativePath);

                // Delete record
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
            'a' => ['name' => 'Scratch', 'color' => '#FF0000'],
            'b' => ['name' => 'Multiple Scratches', 'color' => '#FF7F00'],
            'c' => ['name' => 'Cosmetic Paint', 'color' => '#FFD700'],
            'd' => ['name' => 'Chip', 'color' => '#00AA00'],
            'e' => ['name' => 'Dent', 'color' => '#0000FF'],
            'f' => ['name' => 'Repainted', 'color' => '#4B0082'],
            'g' => ['name' => 'Repaired', 'color' => '#b87bd2ff'],
            'h' => ['name' => 'Foiled Wrap', 'color' => '#706c6eff'],
            'i' => ['name' => 'Full PPF', 'color' => '#d80881ff'],
            'j' => ['name' => 'Rust', 'color' => '#6b5407ff'],
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

    // ✅ Find the inspection report
    $inspection = VehicleInspectionReport::findOrFail($validated['inspection_id']);

    // ✅ Delete old damage records for this inspection
    CarDamage::where('inspection_id', $inspection->id)->delete();

    // ✅ Create new damages
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
    try {
        $reportInView = VehicleInspectionReport::findOrFail($reportId);
    
    

    $damageTypes = [
        'a' => ['name' => 'Scratch',       'color' => '#FF0000'],
        'b' => ['name' => 'Multiple Scratches', 'color' => '#FF7F00'],
        'c' => ['name' => 'Cosmetic Paint', 'color' => '#FFD700'],
        'd' => ['name' => 'Chip',          'color' => '#00AA00'],
        'e' => ['name' => 'Dent',          'color' => '#0000FF'],
        'f' => ['name' => 'Repainted',     'color' => '#4B0082'],
        'g' => ['name' => 'Repaired',      'color' => '#B87BD2'],
        'h' => ['name' => 'Foiled Wrap',   'color' => '#706C6E'],
        'i' => ['name' => 'Full PPF',      'color' => '#D80881'],
        'j' => ['name' => 'Rust',          'color' => '#6B5407'],
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

        // --- NEW: use stored damage PNG instead of generating link ---
       $damageAssessmentImage = $reportInView->damage_file_path
    ? asset('storage/' . $reportInView->damage_file_path)
    : null;

        // --- Generate PDF ---
        $directory = 'inspection_pdf';
        if (! Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        $pdf = Pdf::loadView('pdf.inspection.report-pdf-template', [
            'reportInView'         => $reportInView,
            'damageAssessmentImage' => $damageAssessmentImage, 
            'damageTypes' => $damageTypes, 
            'damages' => $damages, 
        ])->setPaper('a4', 'portrait');
        
        
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