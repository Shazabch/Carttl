<?php

namespace App\Livewire;

use App\Models\InspectionEnquiry;
use Livewire\Component;

class BookInspectionComponent extends Component
{
    public $name;
    public $phone;
    public $email;
    public $type;
    public $date;
    public $time;
    public $location;
    public $year;
    public $make;
    public $model;

    public bool $formSubmitted = false;

    protected function rules()
    {
        return [
            'name' => 'required',
            'phone'    => ['required'],
            'email' => 'required',
            'type' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'year' => 'required',
            'make' => 'required',
            'model' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Number is required.',
            'phone.regex' => 'Please enter a valid Dubai mobile number starting with +9715.',
        ];
    }

    public function saveInspection()
    {
        $validatedData = $this->validate();
        dd('adsf');
        InspectionEnquiry::create($validatedData);

        $this->dispatch('success-notification', message: 'Record Saved Successfully');
        $this->formSubmitted = true;
    }
    public function resetForm()
    {
        $this->reset(['name', 'phone', 'email', 'type', 'date', 'time', 'location', 'year', 'make', 'model']);
        $this->formSubmitted = false; // Set the switch back to false

    }
    public function render()
    {
        return view('livewire.book-inspection-component');
    }
}
