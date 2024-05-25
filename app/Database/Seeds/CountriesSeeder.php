<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'India'],
            ['name' => 'United States'],
            ['name' => 'United Kingdom'],
            ['name' => 'Canada'],
            ['name' => 'Australia']
        ];

        $this->db->table('countries')->insertBatch($data);
    }
}
