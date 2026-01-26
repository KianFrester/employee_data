<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        //  $this->forge->addField([
        //     'id' => [
        //         'type'           => 'INT',
        //         'constraint'     => 11,
        //         'unsigned'       => true,
        //         'auto_increment' => true,
        //     ],
        //     'username' => [
        //         'type'       => 'VARCHAR',
        //         'constraint' => 100,
        //     ],
        //     'password' => [
        //         'type'       => 'VARCHAR',
        //         'constraint' => 50,
        //     ],
        //     'created_at' => [
        //         'type' => 'DATETIME',
        //         'null' => true,
        //         'auto_increment' => true,
        //         'default' => 'CURRENT_TIMESTAMP',
        //     ],
        // ]);

        // $this->forge->addKey('id', true);
        // $this->forge->createTable('users');
    }

    public function down()
    {
        // $this->forge->dropTable('users');
    }
}
