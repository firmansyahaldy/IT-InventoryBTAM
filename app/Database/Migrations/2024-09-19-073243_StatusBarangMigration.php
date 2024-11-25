<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StatusBarangMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_status_barang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'status_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id_status_barang', true);
        $this->forge->createTable('status_barang');
    }

    public function down()
    {
        $this->forge->dropTable('status_barang');
    }
}
