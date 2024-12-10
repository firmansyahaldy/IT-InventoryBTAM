<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StatusMaintenanceMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_status_maintenance' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'status_maintenance' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id_status_maintenance', true);
        $this->forge->createTable('status_maintenance');
    }

    public function down()
    {
        $this->forge->dropTable('status_maintenance');
    }
}
