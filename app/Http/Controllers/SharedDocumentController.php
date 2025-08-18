<?php

namespace App\Http\Controllers;

use App\Models\VehicleInspectionReport;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SharedDocumentController extends Controller
{
    /**
     * Handles the download request from a valid signed URL.
     *
     * @param VehicleInspectionReport $report
     * @return StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function downloadInspectionReport(VehicleInspectionReport $report)
    {
        // 1. Check if the report has a PDF file path associated with it.
        if (!$report->file_path) {
            // Or return a view with an error message
            abort(404, 'PDF file not generated for this report.');
        }

        // 2. Check if the file physically exists in storage.
        if (!Storage::disk('public')->exists($report->file_path)) {
            abort(404, 'The requested file does not exist.');
        }

        // 3. Securely stream the download to the user.
        // Using `download()` sets the correct headers for the browser.
        return Storage::disk('public')->download($report->file_path);
    }
}