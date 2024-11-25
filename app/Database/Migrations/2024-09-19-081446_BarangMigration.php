<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class BarangMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([    
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 64,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'kode_barang' => [
                'type' => 'INT',
                'constraint' => 64,
                'unsigned' => true,
            ],
            'id_kategori' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'nama_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'merk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'spesifikasi' => [
                'type' => 'TEXT',
            ],
            'tipe' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tgl_pembelian' => [
                'type' => 'DATE',
            ],
            'harga_pembelian' => [
                'type' => 'INT',
                'constraint' => 64,
            ],
            'id_status_barang' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'kuantitas' => [
                'type' => 'INT',
                'constraint' => 64,
            ],
            'id_kondisi' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'masa_garansi' => [
                'type' => 'DATE',
            ],
            'serial_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_lokasi_barang' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'maintenance_selanjutnya' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_barang', true);
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kondisi', 'kondisi', 'id_kondisi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_status_barang', 'status_barang', 'id_status_barang', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_lokasi_barang', 'lokasi_barang', 'id_lokasi_barang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}
