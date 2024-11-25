<?php

namespace App\Database\Migrations;
// Mengimpor kelas Migration dari CodeIgniter
use CodeIgniter\Database\Migration;

// Mendeklarasikan kelas KondisiMigration yang merupakan turunan dari Migration
class KondisiMigration extends Migration
{
    // Metode 'up' untuk membuat tabel baru dan menambahkan kolom
    public function up()
    {
        // Menambahkan field/kolom baru pada tabel 'kondisi'
        $this->forge->addField([
            'id_kondisi' => [
                'type'           => 'INT',        // Menentukan tipe data kolom sebagai integer
                'unsigned'       => true,         // Mengatur agar kolom tidak dapat memiliki nilai negatif
                'auto_increment' => true,         // Mengaktifkan fitur auto-increment untuk kolom ini
            ],
            'kondisi_item' => [
                'type'       => 'VARCHAR',       // Menentukan tipe data kolom sebagai string (VARCHAR)
                'constraint' => '50',           // Membatasi panjang karakter maksimum kolom hingga 50 karakter
            ],
        ]);

        // Menambahkan primary key pada kolom 'id_kondisi'
        $this->forge->addKey('id_kondisi', true);

        // Membuat tabel baru bernama 'kondisi' dengan kolom yang telah didefinisikan
        $this->forge->createTable('kondisi');
    }

    // Metode 'down' untuk menghapus tabel jika migrasi dibatalkan (rollback)
    public function down()
    {
        // Menghapus tabel 'kondisi' dari database
        $this->forge->dropTable('kondisi');
    }
}
