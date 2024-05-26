<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['state_id' => 1, 'name' => 'Mumbai'],
            ['state_id' => 1, 'name' => 'Nashik'],
            ['state_id' => 1, 'name' => 'Ahmednagar'],
            ['state_id' => 1, 'name' => 'Sambhaji Nagar'],
            ['state_id' => 1, 'name' => 'Pune'], 
            ['state_id' => 2, 'name' => 'New Delhi'],
            ['state_id' => 3, 'name' => 'Los Angeles'],
            ['state_id' => 3, 'name' => 'San Francisco'],
            ['state_id' => 4, 'name' => 'London'],
            ['state_id' => 5, 'name' => 'Toronto'],
        ];

        $this->db->table('cities')->insertBatch($data);
    }
}
