<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\VehicleModel;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('sql/modelsSeed.sql');

        if (!File::exists($path)) {
            $this->command->error("❌ File not found: {$path}");
            return;
        }

        $sql = File::get($path);

        // Extract all INSERT statements for vehicle_models
        preg_match_all(
            '/INSERT INTO `vehicle_models` .*?VALUES\s*(.+);/is',
            $sql,
            $matches
        );

        if (empty($matches[1])) {
            $this->command->warn('⚠️ No INSERT data found for vehicle_models.');
            return;
        }

        // Combine all value groups (can be multiple INSERT statements)
        $valuesString = implode(' ', $matches[1]);

        // Match each row in parentheses: (1, 72, 'Corolla', '2025-08-05 ...', '2025-08-05 ...')
        preg_match_all(
            "/\((\d+),\s*(\d+),\s*'([^']+)',\s*'([^']+)',\s*'([^']+)'\)/",
            $valuesString,
            $rows,
            PREG_SET_ORDER
        );

        if (empty($rows)) {
            $this->command->warn('⚠️ No rows parsed from INSERT values.');
            return;
        }

        foreach ($rows as $r) {
            [$full, $id, $brand_id, $name, $created_at, $updated_at] = $r;

            VehicleModel::updateOrCreate(
                ['id' => $id],
                [
                    'brand_id'   => $brand_id,
                    'name'       => $name,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]
            );
        }

        $this->command->info("✅ Seeded " . count($rows) . " vehicle models successfully!");
    }
}
