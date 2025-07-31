<?php

namespace App\Livewire\Admin\Inspection;

use App\Models\VehicleInspectionReport; // Use the correct model
use Livewire\Component;
use Livewire\WithPagination;

class GenerationComponent extends Component
{
    use WithPagination;

    // --- Component State (Mirrors VehicleFormComponent) ---
    public $showForm = false;
    public $isEditing = false;
    public $currentStep = 1; // You can keep the wizard logic
    public $search = '';
    public $report_id = null;

    // --- Form Data Holder ---
    public array $reportData = [];

    // --- Data for Dropdowns & Selections (if you have any) ---
    // Example: public $inspectors = [];

    protected $listeners = ['showCreateForm', 'showEditForm'];

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
        // Pre-load any data needed for dropdowns, e.g., a list of inspectors
        // $this->inspectors = User::whereRole('inspector')->get();
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
    }


    // --- Save/Update/Delete Logic ---

    public function saveReport()
    {
        $this->validate();

        // Use updateOrCreate with the data array
        VehicleInspectionReport::updateOrCreate(['id' => $this->report_id], $this->reportData);

        session()->flash('success', $this->isEditing ? 'Report updated successfully.' : 'Report created successfully.');

        $this->cancel();
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->reset();
        $this->mount();
    }

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

        return view('livewire.admin.inspection.generation-component', [
            'reports' => $reports
        ]);
    }
}