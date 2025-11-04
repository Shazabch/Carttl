<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuelType;

class FuelTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Petrol', 'Diesel', 'Electric', 'Hybrid'];

        foreach ($types as $type) {
            FuelType::updateOrCreate(
                ['name' => $type], 
                [] 
            );
        }
    }
}
