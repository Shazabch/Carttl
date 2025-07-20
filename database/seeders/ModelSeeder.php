<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Model;
use App\Models\Brand;
use App\Models\Make;

class ModelSeeder extends Seeder
{
    public function run(): void
    {
        $modelsByBrand = [
            'Toyota' => ['Corolla', 'Camry', 'Hilux', 'Yaris', 'Land Cruiser'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'City', 'Fit'],
            'Ford' => ['Focus', 'Fusion', 'F-150', 'Escape', 'Mustang'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', 'i8'],
            'Audi' => ['A3', 'A4', 'A6', 'Q5', 'Q7'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Kona'],
            'Kia' => ['Sportage', 'Sorento', 'Optima', 'Rio', 'Seltos'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Versa', 'Murano'],
            'Chevrolet' => ['Cruze', 'Malibu', 'Equinox', 'Tahoe', 'Impala'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'GLC', 'GLE', 'S-Class'],
        ];

        foreach ($modelsByBrand as $brandName => $models) {
            $brand = Brand::where('name', $brandName)->first();
            if (!$brand) {
                continue;
            }
            foreach ($models as $modelName) {
                Make::create([
                    'brand_id' => $brand->id,
                    'name' => $modelName,
                ]);
            }
        }
    }
}
