<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class UsersManagementComponent extends Component
{
    use WithPagination;

    public $user_id = null;
    public $name, $email, $password, $role;
    public $search = '';
    public $perPage = 10;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required|string',
            'password' => $this->user_id ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
                     ->orWhere('email', 'like', '%' . $this->search . '%')
                     ->paginate($this->perPage);

        return view('livewire.admin.users-management-component', compact('users'));
    }

    public function addNew()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function editItem($id)
    {

        $user = User::findOrFail($id);

        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->resetValidation();
        $this->dispatch('open-modal');
    }

    public function saveUser()
    {
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(['id' => $this->user_id], $data);
        $this->reset();
        $this->dispatch('close-modal');
        $this->dispatch('success-notification', message: $this->user_id ? 'User updated successfully.' : 'User created successfully.');


    }

    #[On('deleteItem')]
    public function deleteItem($id)
    {
        User::findOrFail($id)->delete();
        $this->dispatch('success-notification', message: 'User deleted successfully.');
    }

}