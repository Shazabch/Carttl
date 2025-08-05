<?php

namespace App\Livewire\Admin\Inspection;

use Livewire\Component;
use App\Models\CarDamage;

class CarDamageView extends Component
{
    public $damages = [];
    public $inspectionId;

    // These are needed to display names and colors correctly in the view
    public $damageTypes = [
        'a' => ['name' => 'Scratch', 'color' => '#FF6B6B'],
        'b' => ['name' => 'Multiple Scratches', 'color' => '#4ECDC4'],
        'c' => ['name' => 'Cosmetic Paint', 'color' => '#45B7D1'],
        'd' => ['name' => 'Chip', 'color' => '#F9CA24'],
        'e' => ['name' => 'Dent', 'color' => '#F0932B'],
        'f' => ['name' => 'Repainted', 'color' => '#9B59B6'],
        'g' => ['name' => 'Repaired', 'color' => '#EB4D4B'],
    ];

    /**
     * Mount the component and load the damages for the given inspection ID.
     *
     * @param int $inspectionId
     */
    public function mount($inspectionId)
    {
        $this->inspectionId = $inspectionId;
        $this->loadDamages();
    }

    /**
     * Load damages from the database based on the inspection ID.
     */
    private function loadDamages()
    {
        $this->damages = CarDamage::where('inspection_id', $this->inspectionId)->get()->toArray();
    }

    /**
     * Render the view-only component.
     */
    public function render()
    {
        return view('livewire.admin.inspection.car-damage-view');
    }
}