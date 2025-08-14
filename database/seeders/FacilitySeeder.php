<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\Material;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facility1 = Facility::create([
            'business_name'    => 'Green Earth Recyclers',
            'last_update_date' => '2023-11-04',
            'street_address'   => '123 5th Ave, New York, NY 10001'
        ]);
        $facility1->materials()->attach([1, 2, 3, 4]); // Computers, Smartphones, Lithium-ion Batteries, AA Batteries

        $facility2 = Facility::create([
            'business_name'    => 'Eco Waste Solutions',
            'last_update_date' => '2023-10-15',
            'street_address'   => '456 Elm St, Los Angeles, CA 90001'
        ]);
        $facility2->materials()->attach([5, 6, 7]); // Plastic, Paper, Glass

        $facility3 = Facility::create([
            'business_name'    => 'Recycle Hub',
            'last_update_date' => '2023-09-20',
            'street_address'   => '789 Pine Rd, Chicago, IL 60601'
        ]);
        $facility3->materials()->attach([1, 5, 8]); // Computers, Plastic, Aluminum
    }
}