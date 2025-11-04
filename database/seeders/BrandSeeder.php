<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('sql/brandsSeed.sql');

        if (!File::exists($path)) {
            $this->command->error("❌ SQL file not found at: {$path}");
            return;
        }

        $sql = File::get($path);

        // Match all value sets like: (1, 'Brand', 'created_at', 'updated_at', ...)
        preg_match_all(
            "/\((\d+),\s*'([^']+)',\s*'([^']+)',\s*'([^']+)',\s*(NULL|'[^']*'),\s*'([^']+)',\s*'([^']+)',\s*'([^']+)',\s*'([^']+)',\s*'([^']+)',\s*'([^']+)',\s*'([^']+)',\s*(\d+)\)/",
            $sql,
            $matches,
            PREG_SET_ORDER
        );

        if (empty($matches)) {
            $this->command->warn('⚠️ No brand records found in the SQL file.');
            return;
        }

        foreach ($matches as $match) {
            [
                $full,
                $id,
                $name,
                $created_at,
                $updated_at,
                $slug,
                $image_source,
                $image_thumb,
                $image_optimized,
                $image_original,
                $local_thumb,
                $local_optimized,
                $local_original,
                $is_active
            ] = $match;

            Brand::updateOrCreate(
                ['id' => $id], // match by ID
                [
                    'name'             => $name,
                    'created_at'       => $created_at,
                    'updated_at'       => $updated_at,
                    'slug'             => $slug === 'NULL' ? null : trim($slug, "'"),
                    'image_source'     => $image_source,
                    'image_thumb'      => $image_thumb,
                    'image_optimized'  => $image_optimized,
                    'image_original'   => $image_original,
                    'local_thumb'      => $local_thumb,
                    'local_optimized'  => $local_optimized,
                    'local_original'   => $local_original,
                    'is_active'        => $is_active,
                ]
            );
        }

        $this->command->info(count($matches) . ' brands inserted or updated successfully!');
    }
}
