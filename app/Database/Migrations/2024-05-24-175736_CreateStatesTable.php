<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatesTable extends Migration
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
            'country_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('states');
    }

    public function down()
    {
        $this->forge->dropTable('states');
    }
}
