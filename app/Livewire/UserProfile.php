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
    public $phone; // Assuming you have a 'phone' column
    public $bio;   // Assuming you have a 'bio' column

    // State management for the UI.
    public bool $isEditing = false;
    public bool $showSuccessIndicator = false;

    // Validation rules.
    protected function rules()
    {
        return [
            'name' => 'required|string|min:3',
            // Ensure email is unique but ignore the current user's email.
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
        ];
    }

    /**
     * The mount method is like a constructor.
     * It runs when the component is first initialized.
     */
    public function mount()
    {
        $this->user = Auth::user();
        $this->resetForm();
    }

    /**
     * Toggles the component into editing mode.
     */
    public function edit()
    {
        $this->isEditing = true;
    }

    /**
     * Cancels editing and resets the form to its original state.
     */
    public function cancel()
    {
        $this->isEditing = false;
        $this->resetForm();
    }

    /**
     * Saves the updated profile information.
     */
    public function save()
    {
        // Validate the form data.
        $validatedData = $this->validate();

        // Update the user model with validated data.
        $this->user->update($validatedData);

        // Reset the form fields with the newly saved data.
        $this->resetForm();

        // Exit editing mode.
        $this->isEditing = false;

        // Show a temporary success message.
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