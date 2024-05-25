<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StatesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['country_id' => 1, 'name' => 'Maharashtra'], // Maharashtra, India
            ['country_id' => 1, 'name' => 'Delhi'], // Delhi, India
            ['country_id' => 2, 'name' => 'California'], // California, United States
            ['country_id' => 3, 'name' => 'England'], // England, United Kingdom
            ['country_id' => 4, 'name' => 'Ontario'], // Ontario, Canada
        ];

        $this->db->table('states')->insertBatch($data);
    }
}
