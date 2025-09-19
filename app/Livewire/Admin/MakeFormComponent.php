<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Support\Str;
use Livewire\Component;

class MakeFormComponent extends Component
{
    public $showForm = false;
    public $isEditing = false;
    public $makeId;
    public $name;

    // repeater for models
    public $models = [];  

    protected $listeners = ['showCreateForm' => 'showCreateForm', 'showEditForm' => 'showEditForm'];

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:brands,name,' . $this->makeId,
            'models.*' => 'nullable|string|max:255', // validate each model input
        ];
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showForm = true;
    }

    public function showEditForm($id)
    {
        $make = Brand::findOrFail($id);

        $this->makeId = $make->id;
        $this->name = $make->name;
        $this->isEditing = true;
        $this->showForm = true;

        // load existing models if editing
        $this->models = $make->models()->pluck('name')->toArray();
    }

    public function addModelField()
    {
        $this->models[] = '';
    }

    public function removeModelField($index)
    {
        unset($this->models[$index]);
        $this->models = array_values($this->models); // reindex
    }

    public function save()
    {
        $this->validate();

        $brand = Brand::updateOrCreate(
            ['id' => $this->makeId],
            ['name' => $this->name, 'slug' => Str::slug($this->name)]
        );

        // save models only when creating or editing
        if (!empty($this->models)) {
            foreach ($this->models as $modelName) {
                if (!empty($modelName)) {
                    VehicleModel::updateOrCreate(
                        ['brand_id' => $brand->id, 'name' => $modelName]
                       
                    );
                }
            }
        }

        $this->dispatch('success-notification', message: $this->isEditing ? 'Make & Models updated successfully.' : 'Make & Models created successfully.');
        $this->dispatch('makeSaved'); // refresh listing

        $this->cancel();
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
        $this->dispatch('closeForm');
    }

    protected function resetForm()
    {
        $this->reset(['makeId', 'name', 'isEditing', 'models']);
    }

    public function render()
    {
        return view('livewire.admin.make-form-component');
    }
}