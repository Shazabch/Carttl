<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Model;
use App\Models\Brand;
use App\Models\Make;
use App\Models\VehicleModel;

class ModelSeeder extends Seeder
{
    public function run(): void
    {
        $modelsByBrand = [
            "Toyota" => ["Corolla", "Camry", "RAV4", "Land Cruiser", "Hilux"],
            "Honda" => ["Civic", "Accord", "CR-V", "Jazz", "HR-V"],
            "Ford" => ["Mustang", "F-150", "Escape", "Explorer", "Ranger"],
            "BMW" => ["3 Series", "5 Series", "X5", "X3", "7 Series"],
            "Audi" => ["A4", "A6", "Q5", "Q7", "A3"],
            "Hyundai" => ["Elantra", "Tucson", "Sonata", "Santa Fe", "Kona"],
            "Kia" => ["Sportage", "Sorento", "Seltos", "Cerato", "Stinger"],
            "Nissan" => ["Altima", "Sentra", "Rogue", "Pathfinder", "370Z"],
            "Chevrolet" => ["Malibu", "Silverado", "Tahoe", "Camaro", "Equinox"],
            "Mercedes-Benz" => ["C-Class", "E-Class", "S-Class", "GLA", "GLE"],
            "Lexus" => ["RX", "NX", "ES", "LS", "GX"],
            "Land Rover" => ["Range Rover", "Defender", "Discovery", "Evoque"],
            "Jaguar" => ["XF", "XE", "F-Pace", "F-Type"],
            "Volkswagen" => ["Golf", "Passat", "Tiguan", "Polo", "Jetta"],
            "Porsche" => ["911", "Cayenne", "Panamera", "Macan"],
            "Rolls-Royce" => ["Phantom", "Ghost", "Cullinan", "Wraith"],
            "Bentley" => ["Continental GT", "Bentayga", "Flying Spur"],
            "Maserati" => ["Ghibli", "Levante", "Quattroporte"],
            "Ferrari" => ["488", "Portofino", "Roma", "SF90"],
            "Lamborghini" => ["Huracan", "Aventador", "Urus"],
            "Suzuki" => ["Swift", "Vitara", "Alto", "Ciaz"],
            "Mazda" => ["CX-5", "Mazda3", "Mazda6", "CX-30"],
            "Mitsubishi" => ["Outlander", "Pajero", "Lancer", "Eclipse Cross"],
            "Jeep" => ["Wrangler", "Cherokee", "Grand Cherokee", "Compass"],
            "GMC" => ["Sierra", "Terrain", "Acadia", "Yukon"],
            "Cadillac" => ["Escalade", "CT5", "XT5", "Lyriq"],
            "Dodge" => ["Charger", "Challenger", "Durango"],
            "Chrysler" => ["300", "Pacifica"],
            "Subaru" => ["Impreza", "Outback", "Forester", "WRX"],
            "Peugeot" => ["208", "3008", "5008", "2008"],
            "Renault" => ["Clio", "Captur", "Megane", "Duster"],
            "Fiat" => ["500", "Panda", "Tipo", "Punto"],
            "Mini" => ["Cooper", "Countryman", "Clubman"],
            "Infiniti" => ["Q50", "QX60", "QX80"],
            "Genesis" => ["G70", "G80", "GV80"],
            "Tesla" => ["Model S", "Model 3", "Model X", "Model Y"],
            "Volvo" => ["XC90", "XC60", "S60", "V60"],
            "Isuzu" => ["D-Max", "MU-X"],
            "SsangYong" => ["Tivoli", "Rexton", "Korando"],
            "Alfa Romeo" => ["Giulia", "Stelvio", "Tonale"],
            "Aston Martin" => ["DB11", "Vantage", "DBX"],
            "Bugatti" => ["Chiron", "Veyron", "Divo"],
            "McLaren" => ["720S", "GT", "Artura"],
            "Opel" => ["Corsa", "Astra", "Insignia"],
            "Skoda" => ["Octavia", "Superb", "Kodiaq", "Fabia"],
            "Citroën" => ["C3", "C4", "Berlingo", "C5 Aircross"],
            "Haval" => ["H6", "Jolion", "H9"],
            "MG" => ["MG3", "ZS", "HS", "MG5"],
            "BYD" => ["Atto 3", "Han", "Tang", "Seal"],
            "Geely" => ["Coolray", "Emgrand", "Azkarra"],
            "Great Wall" => ["Wingle 7", "Poer", "Steed"],
            "Changan" => ["Alsvin", "CS35 Plus", "Eado"],
            "Lincoln" => ["Aviator", "Navigator", "Corsair"],
            "Ram" => ["1500", "2500", "3500"],
            "Seat" => ["Ibiza", "Leon", "Ateca", "Arona"],
            "Polestar" => ["Polestar 2", "Polestar 3"]
        ];


        foreach ($modelsByBrand as $brandName => $models) {
            $brand = Brand::where('name', $brandName)->first();
            if (!$brand) {
                continue;
            }
            foreach ($models as $modelName) {
                VehicleModel::create([
                    'brand_id' => $brand->id,
                    'name' => $modelName,
                ]);
            }
        }
    }
}
