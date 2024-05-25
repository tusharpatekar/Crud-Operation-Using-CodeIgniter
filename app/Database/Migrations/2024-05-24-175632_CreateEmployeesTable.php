<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeesTable extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ],
            'city_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'country_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'gender' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true
            ],
            'education' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'hobbies' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => 'true'
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('employees');
    }

    public function down()
    {
        $this->forge->dropTable('employees');
    }
}
