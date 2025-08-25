<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = ['Airbags', 'ABS', 'Bluetooth', 'Sunroof', 'Backup Camera', 'Cruise Control'];
        $exterior = [
           
            'Alloy Wheels',
            'Halogen Headlights',
            'LED Headlights',
            'Fog Lights',
            'Daytime Running Lights (DRLs)',
            'Side Mirrors with Turn Indicators',
            'Body-Colored Bumpers',
            'Chrome Grille',
            'Rear Wiper & Washer',
            'Mudguards / Mudflaps',

            
            'Steel Wheels',
            'Roof Rails',
            'Sunroof / Moonroof / Panoramic Roof',
            'Spoiler (Rear / Front)',
            'Blacked-out Grille',
            'Tinted Windows',
            'Sliding Doors',
            'Power Tailgate / Trunk',
            'Rain-Sensing Wipers',
            'Heated Side Mirrors',
            'Auto-Folding Side Mirrors',
            'Dual Exhaust Pipes',
            'Tow Hook / Tow Hitch',
            'Side Skirts'
        ];

        $interior = [
           
            'Air Conditioning / Climate Control',
            'Power Windows',
            'Power Door Locks',
            'Fabric Seats',
            'Cup Holders',
            'Adjustable Steering (Tilt / Telescopic)',
            'Steering Wheel Controls',
            'Infotainment System (Touchscreen, Android Auto, Apple CarPlay)',
            'USB Charging Ports',
            'Cruise Control',

           
            'Leather Seats',
            'Power Adjustable Seats',
            'Heated Seats',
            'Ventilated / Cooled Seats',
            'Rear Folding Seats (60:40 split, 40:20:40 split)',
            'Multi-Zone Climate Control',
            'Ambient Lighting',
            'Navigation / GPS',
            'Digital Instrument Cluster',
            'Analog Instrument Cluster',
            'Head-Up Display (HUD)',
            'Push Button Start / Keyless Entry',
            'Wireless Charger',
            'Rear AC Vents',
            'Armrest (Front / Rear)',
            'Premium Sound System',
            'Rear Seat Entertainment Screens',
            'Cabin Air Filter'
        ];

        $tags = ['Luxury', 'Sports Car', 'Certified By GX'];

        foreach ($exterior as $feature) {
            Feature::firstOrCreate(['name' => $feature, 'type' => 'exterior']);
        }

        foreach ($interior as $feature) {
            Feature::firstOrCreate(['name' => $feature, 'type' => 'interior']);
        }
        foreach ($features as $feature) {
            Feature::firstOrCreate(['name' => $feature, 'type' => 'simple']);
        }
        foreach ($tags as $tag) {
            Feature::firstOrCreate(['name' => $tag, 'type' => 'tag']);
        }
    }
}
