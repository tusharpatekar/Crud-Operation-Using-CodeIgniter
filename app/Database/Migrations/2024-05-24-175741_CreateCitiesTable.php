<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'state_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('cities');
    }

    public function down()
    {
        $this->forge->dropTable('cities');
    }
}
