<?php

namespace App\Livewire;

use App\Enums\MileageRange;
use App\Models\Brand;
use App\Models\VehicleModel; // Assuming you have a Model model
use App\Models\SellEnquiry; // To save the final data
use App\Models\User;
use App\Models\VehicleEnquiry;
use App\Notifications\SellEnquiryReceived; // To notify admin
use App\Notifications\VehicleEnquiryNotification;
use App\Notifications\VehicleEnquiryReceivedConfirmation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class SellCarHomeComponent extends Component
{
    // State Management
    public int $step = 1;
    public bool $formSubmitted = false;

    // Form Data
    public array $formData = [
        'brand_id' => null,
        'make_id' => null,
        'year' => null,
        'mileage' => '',
        'specification' => '',
        'notes' => '',
        'name' => '',
        'phone' => '',
        'email' => '',
    ];
    public string $brandSearch = '';

    // Data for dropdowns/lists
    public $brands = [];
    public $models = [];
    public $years = [];
    public $featuredBrands = [];

    // Validation rules for the final step
    protected function rules()
    {
        return [
            'formData.brand_id' => 'required|exists:brands,id',
            'formData.make_id' => 'required|exists:vehicle_models,id',
            'formData.year' => 'required|integer',
            'formData.mileage' => 'required|integer',
            'formData.specification' => 'nullable',
            'formData.notes' => 'nullable|string',
            'formData.name' => 'required|string|max:255',
            'formData.phone' => 'required',
            'formData.email' => 'required|email|max:255',

        ];
    }
    public function messages()
    {
        return [

            'formData.phone.required' => 'The phone number is required.',
            'formData.phone.regex' => 'Please enter a valid Dubai mobile number, e.g., +971 5X XXX XXXX.',
        ];
    }

    public function updated($propertyName)
    {

        if ($this->step === 6) {
            $this->validateOnly($propertyName);
        }
    }
    public function mount()
    {
        $this->featuredBrands = Brand::where('is_active', true)->take(12)->get();
        $this->years = range(now()->year, now()->year - 20);
        $this->formData['mileage'] = array_key_first(MileageRange::options());
    }

    // --- Actions ---

    public function selectBrand($brandId)
    {

        $this->formData['brand_id'] = $brandId;
        $this->models = VehicleModel::where('brand_id', $brandId)->get();
        $this->step = 3; // Move to model selection

    }

    public function selectModel($modelId)
    {

        $this->formData['make_id'] = $modelId;
        $this->step = 4; // Move to year selection
    }

    public function selectYear($year)
    {
        $this->formData['year'] = $year;
        $this->step = 5; // Move to details form
    }

    public function goToStep($stepNumber)
    {

        $this->step = $stepNumber;
    }

    public function submit()
    {

        $this->validate();
        try {

            $this->formData['type'] = 'sale';

            $email = $this->formData['email'];
            if ($email) {
                $user = User::where('email', $email)->first();
                if ($user) {
                } else {
                    $user = User::create([
                        'name' => $this->formData['name'] ?? 'TEST CUSTomer',
                        'email' => $this->formData['email'],
                        'role' => 'customer',
                        'password' => Hash::make('password'),
                    ]);
                    $user->syncRoles('customer');
                }
            }
             $this->formData['user_id'] = $user->id;
            $enquiry = VehicleEnquiry::create($this->formData);
            $recipients = User::role(['admin', 'super-admin'])->get();
            Notification::send($recipients, new VehicleEnquiryNotification($enquiry));

            if ($user) {
                Notification::send($user, new VehicleEnquiryReceivedConfirmation($enquiry));
            }
            $this->formSubmitted = true;
        } catch (\Exception $e) {
            dd($e);
            session()->flash('error', 'Something went wrong. Please try again.');
        }
    }


    public function render()
    {
        $this->brands = Brand::where('name', 'like', '%' . $this->brandSearch . '%')->get();
        return view('livewire.sell-car-home-component');
    }
}
