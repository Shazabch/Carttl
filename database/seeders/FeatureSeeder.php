<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = ['Airbags', 'ABS', 'Bluetooth', 'Sunroof', 'Backup Camera', 'Cruise Control'];
        $exterior = ['Alloy Wheels', 'Sunroof', 'Fog Lights', 'Roof Rails'];
        $interior = ['Leather Seats', 'Heated Seats', 'Touchscreen Display', 'Bluetooth'];
        $tags = ['Luxury', 'Sports Car', 'Certified By GX'];

        foreach ($exterior as $feature) {
            Feature::firstOrCreate(['name' => $feature, 'type' => 'exterior']);
        }

        foreach ($interior as $feature) {
            Feature::firstOrCreate(['name' => $feature, 'type' => 'interior']);
        }
        foreach ($features as $feature) {
            Feature::firstOrCreate(['name' => $feature, 'type' => 'simple']);
        }
         foreach ($tags as $tag) {
            Feature::firstOrCreate(['name' => $tag, 'type' => 'tag']);
        }
    }
}
