<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = ['Airbags', 'ABS', 'Bluetooth', 'Sunroof', 'Backup Camera', 'Cruise Control'];
        foreach ($features as $feature) {
            Feature::create(['name' => $feature]);
        }
    }
}
