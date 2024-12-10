<?php

namespace App\Database\Migrations;
// Menggunakan namespace Migration di CodeIgniter
use CodeIgniter\Database\Migration;

// Mendeklarasikan class migrasi yang bernama KategoriMigration
class KategoriMigration extends Migration
{
    // Metode 'up' untuk menambahkan tabel atau kolom baru pada database
    public function up()
    {
        // Menambahkan field/kolom baru pada tabel 'kategori'
        $this->forge->addField([
            'id_kategori' => [
                'type'           => 'INT',  // Menentukan tipe data kolom sebagai integer
                'unsigned'       => true,   // Mengatur nilai kolom agar tidak memiliki tanda negatif
                'auto_increment' => true,   // Mengaktifkan fitur auto-increment pada kolom ini
            ],
            'kategori_item' => [
                'type'       => 'VARCHAR',  // Menentukan tipe data kolom sebagai string (VARCHAR)
                'constraint' => '255',      // Membatasi panjang karakter maksimum kolom hingga 50 karakter
            ],
        ]);
        // Menambahkan primary key pada kolom 'id_kategori'
        $this->forge->addKey('id_kategori', true);
        // Membuat tabel baru bernama 'kategori' dengan kolom yang telah didefinisikan di atas
        $this->forge->createTable('kategori');
    }

    // Metode 'down' untuk menghapus tabel atau kolom jika migrasi dibatalkan (rollback)
    public function down()
    {
        // Menghapus tabel 'kategori' dari database
        $this->forge->dropTable('kategori');
    }
}
