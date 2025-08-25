<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;

class UsersManagementComponent extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';
    public ?User $editingUser = null;
    public bool $showModal = false;

    public string $search = '';
    public int $perPage = 10;
    public string $password = ''; // keep password separate from model binding

    // protected function rules()
    // {
    //     $userId = $this->editingUser?->id ?? 'NULL';

    //     return [
    //         'editingUser.name' => 'required|string',
    //         'editingUser.email' => 'required|email' . $userId,
    //         'editingUser.role' => 'required|string',
    //         'password' => 'required',
    //     ];
    // }

    public function mount()
    {
        $this->editingUser = new User();
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->paginate($this->perPage);

        return view('livewire.admin.users-management-component', [
            'users' => $users,
        ]);
    }

    public function addNew()
    {
        // $this->resetValidation();
        $this->editingUser = new User();
        $this->password = '';
        $this->showModal = true;
    }

    public function editItem(int $id)
    {
        $this->editingUser = User::findOrFail($id);
        $this->password = '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function saveUser()
    {
        // $this->validate();

        $data = $this->editingUser->toArray();
         dd($data);
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        } elseif ($this->editingUser->exists) {
            unset($data['password']);
        }

        User::updateOrCreate(
            ['id' => $this->editingUser->id],
            $data
        );

        $this->showModal = false;

        $message = $this->editingUser->id ? 'User updated successfully.' : 'User created successfully.';
        $this->dispatch('success-notification', message: $message);

        $this->editingUser = new User();
        $this->password = '';
    }

    #[On('deleteItem')]
    public function deleteItem(int $id)
    {
        User::findOrFail($id)->delete();

        $this->dispatch('success-notification', message: 'User deleted successfully.');
    }
}
