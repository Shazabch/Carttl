<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfile extends Component
{
    // The User model instance.
    public User $user;

    // Form properties.
    public $name;
    public $email;
    public $phone; 
    public $bio;   

    // State management for the UI.
    public bool $isEditing = false;
    public bool $showSuccessIndicator = false;

    // Validation rules.
    protected function rules()
    {
        return [
            'name' => 'required|string|min:3',
           
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|max:13',
            'bio' => 'nullable|string|max:500',
        ];
    }

   
    public function mount()
    {
        $this->user = Auth::user();
        $this->resetForm();
    }

    
    public function edit()
    {
        $this->phone=$this->user->phone;
        $this->isEditing = true;
    }

   
    public function cancel()
    {
        $this->isEditing = false;
        $this->resetForm();
    }

   
    public function save()
    {
        $validatedData = $this->validate();
        $this->user->update($validatedData);
        $this->isEditing = false;
        $this->showSuccessIndicator = true;
    }

    /**
     * Helper method to reset form properties from the model.
     */
    private function resetForm()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->bio = $this->user->bio;
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}