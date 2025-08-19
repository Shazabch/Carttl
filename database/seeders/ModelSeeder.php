<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Support\Facades\File;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder is non-destructive. It will:
     * 1. Update or create brands, ensuring they are active.
     * 2. Add only new models for each brand.
     * It can be run multiple times safely without truncating data.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/car-list.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("The file car-list.json was not found in database/seeders/");
            return;
        }

        $carData = json_decode(File::get($jsonPath), true);

        if (is_null($carData)) {
            $this->command->error("The JSON file is malformed or empty.");
            return;
        }

        $this->command->info('Starting to seed/update vehicle brands and models...');

        foreach ($carData as $data) {
            $brandName = $data['brand'];
            $modelsFromJson = $data['models'];

            if (empty($brandName)) {
                continue;
            }

            // Step 1: Use updateOrCreate for the Brand.
            // This finds a brand by name or creates it if it doesn't exist.
            // In either case, it ensures 'is_active' is set to 1.
            $brand = Brand::updateOrCreate(
                ['name' => $brandName],
                ['is_active' => 1]
            );

            // Step 2: Efficiently find new models to add.
            if (empty($modelsFromJson)) {
                continue;
            }

            // Get all existing model names for the current brand in a single query.
            $existingModels = VehicleModel::where('brand_id', $brand->id)
                ->pluck('name')
                ->all();

            // Create a lookup array for fast checking (O(1) complexity).
            $existingModelsLookup = array_flip($existingModels);

            $modelsToInsert = [];

            // Compare models from JSON with existing ones.
            foreach ($modelsFromJson as $modelName) {
                // If the model name is not in our lookup array, it's new.
                if (!isset($existingModelsLookup[$modelName])) {
                    $modelsToInsert[] = [
                        'brand_id'   => $brand->id,
                        'name'       => $modelName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Step 3: Perform a bulk insert for only the new models.
            // This is far more efficient than calling create() in a loop.
            if (!empty($modelsToInsert)) {
                VehicleModel::insert($modelsToInsert);
                $this->command->info("Added " . count($modelsToInsert) . " new models for {$brandName}.");
            } else {
                 // Un-comment the line below if you want verbose output even when no models are added.
                 // $this->command->line("No new models to add for {$brandName}.");
            }
        }

        $this->command->info('Vehicle brands and models seeded/updated successfully!');
    }
}