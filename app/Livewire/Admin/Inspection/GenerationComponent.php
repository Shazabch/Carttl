<?php

namespace App\Livewire\Admin\Inspection;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\FuelType;
use App\Models\Transmission;
use App\Models\VehicleInspectionReport; // Use the correct model
use App\Models\VehicleModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class GenerationComponent extends Component
{
    use WithPagination;

    // --- Component State (Mirrors VehicleFormComponent) ---
    public $showForm = false;
    public $isEditing = false;
    public $currentStep = 1; // You can keep the wizard logic
    public $search = null;
    public $report_id = null;

    public $showDetails = false;
    public ?VehicleInspectionReport $reportInView = null;

    // --- Form Data Holder ---
    public array $reportData = [];

    public $brands = [], $models = [], $bodyTypes = [], $fuelTypes = [], $transmissions = [];

    protected $listeners = ['showCreateForm', 'showEditForm'];



    // In GenerationComponent.php

    public ?string $modalForProperty = null;

    public function openModal(string $property)
    {
        $this->modalForProperty = $property;
    }

    public function closeModal()
    {
        $this->modalForProperty = null;
    }
    // --- Validation Rules ---
    protected function rules()
    {
        // Add rules for your inspection report fields
        return [
            'reportData.make' => 'required|string|max:255',
            'reportData.model' => 'required|string|max:255',
            'reportData.year' => 'required|integer|digits:4',
            'reportData.vin' => 'required|string|max:255',
            'reportData.odometer' => 'required|string',
            'reportData.overallCondition' => 'required|string',
            // ... Add other required rules ...
        ];
    }

    // --- Initialization ---
    private function initializeReportData()
    {
        $this->reportData = (new VehicleInspectionReport())->getAttributes();
        // Initialize all the array properties to prevent errors
        $arrayFields = ['paintCondition', 'frontLeftTire', 'rearRightTire', 'seatsCondition', 'brakeDiscs', 'shockAbsorberOperation'];
        foreach ($arrayFields as $field) {
            $this->reportData[$field] = [];
        }
    }

    public function mount()
    {
        $this->initializeReportData();
        $this->brands =  Brand::orderBy('name')->get();
        $this->brands = $this->brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'text' => $brand->name,
            ];
        })->toArray();
        $this->bodyTypes = BodyType::all();
        $this->fuelTypes = FuelType::all();
        $this->transmissions = Transmission::all();
        // Pre-load any data needed for dropdowns, e.g., a list of inspectors
        // $this->inspectors = User::whereRole('inspector')->get();
    }
    public function updatedReportDataMake($value)
    {


        if ($value) {
            $this->models = VehicleModel::where('brand_id', $value)->get();

            $this->models = $this->models->map(function ($model) {
                return [
                    'id' => $model->id,
                    'text' => $model->name,
                ];
            })->toArray();
        } else {
            $this->models = [];
        }

        $this->dispatch('re-init-select-2-component');
        $this->reportData['model'] = null; // Reset vehicle_model_id in our data array
    }

    // --- WIZARD CONTROLS ---
    public function nextStep()
    {
        // $this->validateStep($this->currentStep);
        if ($this->currentStep < 3) {
            $this->currentStep++;
        } elseif ($this->currentStep == 3) {
            $this->saveReport();
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) $this->currentStep--;
    }


    // --- Form Visibility and Data Loading ---

    public function showCreateForm()
    {
        $this->isEditing = false;
        $this->reset(); // Livewire's built-in reset
        $this->mount(); // Re-initialize with default values
        $this->currentStep = 1;
        $this->showForm = true;
        $this->showDetails = false;
    }

    public function showEditForm($reportId)
    {
        $this->isEditing = true;
        $report = VehicleInspectionReport::findOrFail($reportId);
        $this->report_id = $reportId;

        // Load the data into the array
        $this->reportData = $report->toArray();

        $this->currentStep = 1;
        $this->showForm = true;
        $this->showDetails = false;
    }
    // NEW Method to show the details view
    public function showReportDetails($reportId)
    {
        $this->reportInView = VehicleInspectionReport::findOrFail($reportId);
        $this->showDetails = true;
        $this->showForm = false; // Hide the form/wizard
    }


    // --- Save/Update/Delete Logic ---

    public function saveReport()
    {
        // $this->validate();


        // Use updateOrCreate with the data array
        VehicleInspectionReport::updateOrCreate(['id' => $this->report_id], $this->reportData);

        session()->flash('success', $this->isEditing ? 'Report updated successfully.' : 'Report created successfully.');

        $this->cancel();
    }

    public function cancel()
    {
        $this->showForm = false;
         $this->showDetails = false;
        $this->reportInView = null;
        $this->reset();
        $this->mount();
    }
     public function generatePdf($reportId)
    {
        $report = VehicleInspectionReport::findOrFail($reportId);

        $pdf = Pdf::loadView('admin.inspection.report-pdf-template', ['report' => $report]);
        $pdf->setPaper('a4', 'portrait');
        $filename = 'inspection-report-' . $report->id . '-' . $report->vin . '.pdf';

        // This is the key part for Livewire: return a file download response
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $filename);
    }

    #[On('deleteReport')]
    public function deleteReport($id)
    {
        VehicleInspectionReport::findOrFail($id)->delete();
        session()->flash('success', 'Report deleted successfully.');
        // The component will re-render, effectively refreshing the list
    }


    // --- Helper Methods ---

    public function setSingleSelection(string $property, $value)
    {
        $currentValue = $this->reportData[$property] ?? null;
        $this->reportData[$property] = ($currentValue == $value) ? null : $value;
    }

    public function toggleArrayValue(string $property, string $value)
    {
        $array = $this->reportData[$property] ?? [];
        if (($key = array_search($value, $array)) !== false) {
            unset($array[$key]);
        } else {
            $array[] = $value;
        }
        $this->reportData[$property] = array_values($array);
    }


    // --- Render Method ---

    public function render()
    {
        // Fetch reports for the list view

        $reports = VehicleInspectionReport::where('vin', 'like', '%' . $this->search . '%')
            ->orWhere('make', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        $this->dispatch('re-init-select-2-component');
        return view('livewire.admin.inspection.generation-component', [
            'reports' => $reports
        ]);
    }
}
