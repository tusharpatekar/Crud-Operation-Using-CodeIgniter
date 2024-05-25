<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['state_id' => 1, 'name' => 'Mumbai'], // Mumbai, Maharashtra, India
            ['state_id' => 1, 'name' => 'Pune'], // Pune, Maharashtra, India
            ['state_id' => 2, 'name' => 'New Delhi'], // New Delhi, Delhi, India
            ['state_id' => 3, 'name' => 'Los Angeles'], // Los Angeles, California, United States
            ['state_id' => 3, 'name' => 'San Francisco'], // San Francisco, California, United States
            ['state_id' => 4, 'name' => 'London'], // London, England, United Kingdom
            ['state_id' => 5, 'name' => 'Toronto'], // Toronto, Ontario, Canada
        ];

        $this->db->table('cities')->insertBatch($data);
    }
}
