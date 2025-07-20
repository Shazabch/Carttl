<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CarDamage;

class CarDamageAssessment extends Component
{
    public $damages = [];
    public $currentDamageType = 'a';
    public $currentSeverity = 'low';
    public $mode = 'add';
    public $showLabels = false;
    public $showPaintedAreas = false;
    public $viewAllFaults = false;
    public $remark = '';
    public $damageTypes = [
        'a' => ['name' => 'Scratch', 'color' => '#FF6B6B'],
        'b' => ['name' => 'Multiple Scratches', 'color' => '#4ECDC4'],
        'c' => ['name' => 'Cosmetic Paint', 'color' => '#45B7D1'],
        'd' => ['name' => 'Chip', 'color' => '#F9CA24'],
        'e' => ['name' => 'Dent', 'color' => '#F0932B'],
        'f' => ['name' => 'Repainted', 'color' => '#9B59B6'],
        'g' => ['name' => 'Repaired', 'color' => '#EB4D4B'],
    ];
    public $severityLevels = [
        'low' => ['name' => 'Low', 'description' => 'Minor damage, cosmetic only'],
        'medium' => ['name' => 'Medium', 'description' => 'Moderate damage, may need attention'],
        'high' => ['name' => 'High', 'description' => 'Significant damage, requires repair'],
        'critical' => ['name' => 'Critical', 'description' => 'Severe damage, immediate attention needed'],
    ];

    protected $rules = [
        'currentDamageType' => 'required',
        'currentSeverity' => 'required',
    ];

    public function mount()
    {
        $this->damages = CarDamage::all()->toArray();
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function setCurrentDamageType($type)
    {
        $this->currentDamageType = $type;
    }

    public function setCurrentSeverity($severity)
    {
        $this->currentSeverity = $severity;
    }

    public function addDamage($x, $y, $bodyPart)
    {
        $this->validate();

        $damage = CarDamage::create([
            'type' => $this->currentDamageType,
            'body_part' => $bodyPart,
            'severity' => $this->currentSeverity,
            'x' => $x,
            'y' => $y,
            'remark' => '',
        ]);
        $this->damages = CarDamage::all()->toArray();
        $this->dispatch('damageAdded');
    }

    public function removeDamage($id)
    {
        CarDamage::find($id)?->delete();
        $this->damages = CarDamage::all()->toArray();
    }

    public function updateRemark($id, $remark)
    {
        $damage = CarDamage::find($id);
        if ($damage) {
            $damage->remark = $remark;
            $damage->save();
            $this->damages = CarDamage::all()->toArray();
        }
    }

    public function clearAll()
    {
        CarDamage::truncate();
        $this->damages = [];
    }

    public function render()
    {
        return view('livewire.car-damage-assessment');
    }
}
