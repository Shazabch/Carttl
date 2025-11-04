<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BodyType;

class BodyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Sedan', 'SUV', 'Hatchback', 'Truck', 'Coupe'];
        foreach ($types as $type) {
            BodyType::updateOrCreate(['name' => $type]);
        }
    }
}
