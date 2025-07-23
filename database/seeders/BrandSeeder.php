<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {



        // ...existing code...
        $brands = [
            "Toyota",
            "Honda",
            "Ford",
            "BMW",
            "Audi",
            "Hyundai",
            "Kia",
            "Nissan",
            "Chevrolet",
            "Mercedes-Benz",
            "Lexus",
            "Land Rover",
            "Jaguar",
            "Volkswagen",
            "Porsche",
            "Rolls-Royce",
            "Bentley",
            "Maserati",
            "Ferrari",
            "Lamborghini",
            "Suzuki",
            "Mazda",
            "Mitsubishi",
            "Jeep",
            "GMC",
            "Cadillac",
            "Dodge",
            "Chrysler",
            "Subaru",
            "Peugeot",
            "Renault",
            "Fiat",
            "Mini",
            "Infiniti",
            "Genesis",
            "Tesla",
            "Volvo",
            "Isuzu",
            "SsangYong",
            "Alfa Romeo",
            "Aston Martin",
            "Bugatti",
            "McLaren",
            "Opel",
            "Skoda",
            "Citroën",
            "Haval",
            "MG",
            "BYD",
            "Geely",
            "Great Wall",
            "Changan",
            "Lincoln",
            "Ram",
            "Seat",
            "Polestar"
        ];
        //
        foreach ($brands as $name) {
            Brand::create(['name' => $name]);
        }
    }
}
