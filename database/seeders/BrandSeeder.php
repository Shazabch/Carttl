<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Support\Facades\File;

class BrandSeeder extends Seeder
{
    
    public function run(): void
    {
       
        $json = File::get(database_path('data/brands.json'));
        $brandsData = json_decode($json);

        foreach ($brandsData as $brandData) {
           
            Brand::updateOrCreate(
                [
                    'name' => $brandData->name 
                ],
                [
                
                    "name" => $brandData->name,
                    "image_source" => $brandData->image->source,
                    "image_thumb" => $brandData->image->thumb,
                    "image_optimized" => $brandData->image->optimized,
                    "image_original" => $brandData->image->original,
                    "local_thumb" => $brandData->image->localThumb,
                    "local_optimized" => $brandData->image->localOptimized,
                    "local_original" => $brandData->image->localOriginal
                ]
            );
        }

       
    }
}