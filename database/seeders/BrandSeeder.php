<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = ["Toyota", "Honda", "Ford", "BMW", "Audi", "Hyundai", "Kia", "Nissan", "Chevrolet", "Mercedes-Benz"];
        foreach ($brands as $name) {
            Brand::create(['name' => $name]);
        }
    }
}
