<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transmission;

class TransmissionSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Manual', 'Automatic', 'CVT'];
        foreach ($types as $type) {
            Transmission::create(['name' => $type]);
        }
    }
}
