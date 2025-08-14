<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            'Computers',
            'Smartphones',
            'Lithium-ion Batteries',
            'AA Batteries',
            'Plastic',
            'Paper',
            'Glass',
            'Aluminum'
        ];

        foreach ($materials as $name) {
            Material::create(['name' => $name]);
        }
    }
}