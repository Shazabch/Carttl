<?php

namespace App\Livewire\Admin\Inspection;

use App\Models\BodyType;
use App\Models\Brand;
use App\Models\FuelType;
use App\Models\InspectionEnquiry;
use App\Models\Transmission;
use App\Models\VehicleInspectionReport;
use App\Models\VehicleModel;
use App\Models\Vehicle;
use App\Models\VehicleDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class GenerationComponent extends Component
{
    use WithPagination;
    public $showForm = false;
    public $isEditing = false;
    public $currentStep = 1;
    public $search = null;
    public $report_id = null;
    public $inspectionId;

    public $showDetails = false;
    public ?VehicleInspectionReport $reportInView = null;
    protected string $paginationTheme = 'bootstrap';

    public array $reportData = [];

    public $brands = [], $models = [], $bodyTypes = [], $fuelTypes = [], $transmissions = [];

    protected $listeners = ['showCreateForm', 'showEditForm'];
    public ?string $modalForProperty = null;
    public ?int $linkedVehicleId = null;
    public ?Vehicle $linkedVehicle = null;
    public ?int $linkedEnquiryId = null;

    public function openModal(string $property)
    {
        $this->modalForProperty = $property;
    }
    public function closeModal()
    {
        $this->modalForProperty = null;
    }
    protected function rules()
    {
        return [
            'reportData.make' => 'required|string|max:255',
            'reportData.model' => 'required|string|max:255',
            'reportData.year' => 'required|integer|digits:4',
            'reportData.vin' => 'required|string|max:255',
            'reportData.odometer' => 'required|string',
            'reportData.overallCondition' => 'required|string',
        ];
    }
    private function initializeReportData()
    {
        $this->reportData = (new VehicleInspectionReport())->getAttributes();
        $arrayFields = ['paintCondition', 'frontLeftTire', 'rearRightTire', 'seatsCondition', 'brakeDiscs', 'shockAbsorberOperation'];
        foreach ($arrayFields as $field) {
            $this->reportData[$field] = [];
        }
    }

    public function mount($vehicleId = null, $enquiryId = null)
    {

        $this->initializeReportData();
        $this->brands =  Brand::orderBy('name')->get()->map(fn($b) => ['id' => $b->id, 'text' => $b->name])->toArray();
        $this->bodyTypes = BodyType::all();
        $this->fuelTypes = FuelType::all();
        $this->transmissions = Transmission::all();
        if ($vehicleId) {
            $this->linkedVehicleId = $vehicleId;
        }
        if ($enquiryId) {
            $this->linkedEnquiryId = $enquiryId;
        }
    }
    private function loadDataFromVehicle(int $vehicleId)
    {
        $vehicle = Vehicle::find($vehicleId);

        if ($vehicle) {
            $this->linkedVehicle = $vehicle;
            $this->reportData['vehicle_id'] = $this->linkedVehicleId;
            $this->reportData['make']           = $vehicle->brand->name;
            $this->reportData['model']          = $vehicle->vehicleModel->name;
            $this->reportData['year']           = $vehicle->year;
            $this->reportData['vin']            = $vehicle->vin;
            $this->reportData['engine_cc']      = $vehicle->engine_cc;
            $this->reportData['horsepower']     = $vehicle->horsepower;
            $this->reportData['noOfCylinders']  = $vehicle->no_of_cylinders;
            $this->reportData['transmission']   = $vehicle->transmission->name;
            $this->reportData['color']          = $vehicle->color;
            $this->reportData['specs']          = $vehicle->specs;
            $this->reportData['odometer']          = $vehicle->mileage;
            $this->reportData['noOfCylinders']          = $vehicle->noOfCylinders;
            $this->reportData['body_type']      = $vehicle->bodyType->name;
        }
    }
    private function loadDataFromEnquiry(int $enquiryId)
    {
        $enquiry = InspectionEnquiry::find($enquiryId);
        if ($enquiry) {
            $this->reportData['make']           = $enquiry->make;
            $this->reportData['model']          = $enquiry->model;
            $this->reportData['year']           = $enquiry->year;
        }
    }
    public function nextStep()
    {
        // $this->validateStep($this->currentStep);
        if ($this->currentStep < 3) {
            $this->currentStep++;
        } elseif ($this->currentStep == 3 || $this->currentStep == 4) {
            $this->saveReport();
        }
    }
    public function prevStep()
    {
        if ($this->currentStep > 1) $this->currentStep--;
    }
    public function showCreateForm()
    {
        $this->isEditing = false;
        $this->currentStep = 1;
        $this->showForm = true;
        $this->showDetails = false;
        if ($this->linkedEnquiryId) {
            $this->loadDataFromEnquiry($this->linkedEnquiryId);
        } elseif ($this->linkedVehicleId) {
            $this->loadDataFromVehicle($this->linkedVehicleId);
        }
    }

    public function showEditForm($reportId)
    {
        $this->isEditing = true;
        $report = VehicleInspectionReport::findOrFail($reportId);
        $this->report_id = $reportId;
        $this->reportData = $report->toArray();
        $this->currentStep = 1;
        $this->showForm = true;
        $this->showDetails = false;
    }
    public function showReportDetails($reportId)
    {
        $this->reportInView = VehicleInspectionReport::findOrFail($reportId);
        $this->showDetails = true;
        $this->showForm = false;
    }
    public function saveReport()
    {
        // $this->validate();
        $this->reportData['vehicle_id'] = $this->linkedVehicleId;
        $this->reportData['inspection_enquiry_id'] = $this->linkedEnquiryId;
        $inspection = VehicleInspectionReport::updateOrCreate(['id' => $this->report_id], $this->reportData);
        $this->inspectionId = $inspection->id;
        if ($this->currentStep == 3) {
            $this->currentStep++;
        } else {

            session()->flash('success', $this->isEditing ? 'Report updated successfully.' : 'Report created successfully.');
            $this->cancel();
        }
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->showDetails = false;
        $this->reportInView = null;
        $this->reset(['reportData']);
    }

    public function generatePdf($reportId)
    {
        $report = VehicleInspectionReport::findOrFail($reportId);
        if ($report->vehicle_id) {
            $directory = 'inspection_pdf';
            // Generate PDF
            $pdf = Pdf::loadView('admin.inspection.report-pdf-template', ['report' => $report])->setPaper('a4', 'portrait')->setOption('defaultFont', 'Arial');
            // Ensure the directory exists
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $filename = 'inspection_' . $report->id  . '_' . now()->format('Ymd_His') . '.pdf';
            $filepath = $directory . '/' . $filename;
            Storage::disk('public')->put($filepath, $pdf->output());
            $vehicleDoc = new VehicleDocument();
            $vehicleDoc->vehicle_id  =  $report->vehicle_id;
            $vehicleDoc->file_path = $filepath;
            $vehicleDoc->type = 'InspectionReport';
            $vehicleDoc->save();
        }
        $this->reset();
    }

    #[On('deleteReport')]
    public function deleteReport($id)
    {
        VehicleInspectionReport::findOrFail($id)->delete();
        session()->flash('success', 'Report deleted successfully.');
    }

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
    public function render()
    {

        $query = VehicleInspectionReport::query();
        if ($this->linkedEnquiryId) {
            $query->where('inspection_enquiry_id', $this->linkedEnquiryId);
        } elseif ($this->linkedVehicleId) {
            $query->where('vehicle_id', $this->linkedVehicleId);
        }
        if ($this->search) {
            $query->where(function ($searchQuery) {
                $searchQuery->where('vin', 'like', '%' . $this->search . '%')
                    ->orWhere('make', 'like', '%' . $this->search . '%');
            });
        }
        $reports = $query->latest()->paginate(10);
        $this->dispatch('re-init-select-2-component');
        return view('livewire.admin.inspection.generation-component', [
            'reports' => $reports
        ]);
    }
}
