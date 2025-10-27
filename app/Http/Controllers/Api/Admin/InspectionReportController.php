<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarDamage;
use App\Models\InspectionEnquiry;
use App\Models\VehicleDocument;
use App\Models\VehicleInspectionImage;
use App\Models\VehicleInspectionReport;
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
        $query = VehicleInspectionReport::query();

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
                    ->orWhere('make', 'like', "%{$s}%")
                    ->orWhere('model', 'like', "%{$s}%");
            });
        }

        $perPage = $request->get('per_page', 10);

        $reports = $query->latest()->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data'   => $reports,
        ]);
    }

    public function show($id)
    {
        $report = VehicleInspectionReport::with('vehicle')->findOrFail($id);

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
            'paintCondition'         => 'nullable|array',
            'frontLeftTire'          => 'nullable|array',
            'rearRightTire'          => 'nullable|array',
            'seatsCondition'         => 'nullable|array',
            'brakeDiscs'             => 'nullable|array',
            'shockAbsorberOperation' => 'nullable|array',
            'notes'                  => 'nullable|string',
        ];

        $validated = $request->validate($rules);

        $reportData = $request->except('damage_image');
        $report     = VehicleInspectionReport::create($reportData);

        if ($request->hasFile('damage_image')) {
            $file   = $request->file('damage_image');
            $pngDir = 'damage-assessments';
            if (! Storage::disk('public')->exists($pngDir)) {
                Storage::disk('public')->makeDirectory($pngDir);
            }
            $pngFilename = 'damage-image-' . $report->id . '-' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();
            $pngPath     = $pngDir . '/' . $pngFilename;
            Storage::disk('public')->putFileAs($pngDir, $file, $pngFilename);
            if ($report->vehicle_id) {
                VehicleDocument::create([
                    'vehicle_id' => $report->vehicle_id,
                    'file_path'  => $pngPath,
                    'type'       => 'InspectionReportImage',
                ]);
            }

            // Save path in the report
            $report->update(['damage_file_path' => $pngPath]);
        }

        $this->generatePdf($report->id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Report created successfully',
            'data'    => $report->fresh(),
        ], 201);
    }

    public function storeImages(Request $request)
    {
        $validated = $request->validate([
            'vehicle_inspection_report_id' => 'required|exists:vehicle_inspection_reports,id',
            'images'                       => 'required|array|min:1',
            'images.*'                     => 'file|mimes:jpg,jpeg,png,webp',
            'is_cover'                     => 'nullable|boolean',
        ]);

        $uploaded  = [];
        $sortOrder = 1;

        foreach ($request->file('images') as $file) {

            $path = $file->store('inspection_images', 'public');

            $image = VehicleInspectionImage::create([
                'vehicle_inspection_report_id' => $validated['vehicle_inspection_report_id'],
                'path'                         => $path,
                'is_cover'                     => $request->get('is_cover', false),
                'sort_order'                   => $sortOrder++,
            ]);

            $uploaded[] = $image;
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Images uploaded successfully.',
            'data'    => $uploaded,
        ], 201);
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
            'paintCondition'         => 'nullable|array',
            'frontLeftTire'          => 'nullable|array',
            'rearRightTire'          => 'nullable|array',
            'seatsCondition'         => 'nullable|array',
            'brakeDiscs'             => 'nullable|array',
            'shockAbsorberOperation' => 'nullable|array',
            'notes'                  => 'nullable|string',
        ];

        $validated = $request->validate($rules);

        $updateData = $request->except('damage_image');
        $report->update($updateData);
        if ($request->hasFile('damage_image')) {
            $file   = $request->file('damage_image');
            $pngDir = 'damage-assessments';
            if (! Storage::disk('public')->exists($pngDir)) {
                Storage::disk('public')->makeDirectory($pngDir);
            }
            $pngFilename = 'damage-image-' . $report->id . '-' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();
            $pngPath     = $pngDir . '/' . $pngFilename;
            Storage::disk('public')->putFileAs($pngDir, $file, $pngFilename);
            if ($report->vehicle_id) {
                VehicleDocument::create([
                    'vehicle_id' => $report->vehicle_id,
                    'file_path'  => $pngPath,
                    'type'       => 'InspectionReportImage',
                ]);
            }
            $report->update(['damage_file_path' => $pngPath]);
        }

        // 🟢 Regenerate PDF after update
        $this->generatePdf($report->id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Report updated successfully',
            'data'    => $report->fresh(),
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
        ]);

        $inspection   = VehicleInspectionReport::findOrFail($validated['inspection_id']);
        $savedDamages = [];

        foreach ($validated['damages'] as $damageData) {
            $damage = new CarDamage([
                'type'      => $damageData['type'],
                'body_part' => $damageData['body_part'],
                'severity'  => $damageData['severity'],
                'x'         => $damageData['x'],
                'y'         => $damageData['y'],
                'remark'    => $damageData['remark'] ?? null,
            ]);

            $damage->inspection_id = $inspection->id;
            $damage->save();

            $savedDamages[] = $damage;
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Damages added successfully.',
            'data'    => $savedDamages,
        ], 201);
    }
    public function removeDamage(Request $request)
    {
        $validated = $request->validate([
            'damage_ids'   => 'required|array|min:1',
            'damage_ids.*' => 'integer|exists:car_damages,id',
        ]);

        $deletedCount = \App\Models\CarDamage::whereIn('id', $validated['damage_ids'])->delete();

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

            // --- Generate PDF ---
            $damageAssessmentLink = URL::temporarySignedRoute(
                'inspection.report.damage-assessment.view',
                now()->addDays(30),
                ['report' => $reportInView->id]
            );

            $directory = 'inspection_pdf';
            if (! Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $pdf = Pdf::loadView('pdf.inspection.report-pdf-template', [
                'reportInView'         => $reportInView,
                'damageAssessmentLink' => $damageAssessmentLink,
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
                    'image_url' => $reportInView->damage_file_path ? asset('storage/' . $reportInView->damage_file_path) : null,
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
