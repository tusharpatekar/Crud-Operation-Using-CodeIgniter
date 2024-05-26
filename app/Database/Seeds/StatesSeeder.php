<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StatesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['country_id' => 1, 'name' => 'Maharashtra'], 
            ['country_id' => 1, 'name' => 'Delhi'],
            ['country_id' => 2, 'name' => 'California'],
            ['country_id' => 3, 'name' => 'England'],
            ['country_id' => 4, 'name' => 'Ontario'],
        ];

        $this->db->table('states')->insertBatch($data);
    }
}
