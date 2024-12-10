<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarangKeluarMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang_keluar' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 64,
                'unsigned' => true,
            ],
            'nama_barang' => [
                'type' => 'TEXT',
            ],
            'jumlah' => [
                'type' => 'INT',
            ],
            'id_kondisi' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'tanggal_keluar' => [
                'type' => 'DATE',
            ],
            'nama_penanggung_jawab' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'lama_peminjaman' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'estimasi_pengembalian' => [
                'type' => 'DATE',
            ],
            'alasan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status_pengembalian' => [
                'type' => 'ENUM',
                'constraint' => ['Belum Dikembalikan', 'Sudah Dikembalikan'],
                'default' => 'Belum Dikembalikan',
            ],
            'tanggal_kembali' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_barang_keluar', true);
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('barang_keluar');
    }

    public function down()
    {
        $this->forge->dropTable('barang_keluar');
    }
}
