<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LokasiBarangMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lokasi_barang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'lokasi_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id_lokasi_barang', true);
        $this->forge->createTable('lokasi_barang');
    }

    public function down()
    {
        $this->forge->dropTable('lokasi_barang');
    }
}
