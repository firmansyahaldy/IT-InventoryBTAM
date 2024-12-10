<?php

namespace App\Database\Migrations;
// Menggunakan namespace Migration di CodeIgniter

use CodeIgniter\Database\Migration;
// Mendeklarasikan class migrasi yang bernama RoleMigration
class RoleMigration extends Migration
{
    // Metode 'up' untuk menambahkan tabel atau kolom baru pada database
    public function up()
    {
        // Menambahkan field/kolom baru pada tabel 'role'
        $this->forge->addField([
            'id_role' => [
                'type'           => 'INT',  // Menentukan tipe data kolom sebagai integer
                'unsigned'       => true,   // Mengatur nilai kolom agar tidak memiliki tanda negatif
                'auto_increment' => true,   // Mengaktifkan fitur auto-increment pada kolom ini
            ],
            'user_role' => [
                'type'       => 'VARCHAR',  // Menentukan tipe data kolom sebagai string (VARCHAR)
                'constraint' => '50',       // Membatasi panjang karakter maksimum kolom hingga 50 karakter
            ],
        ]);

        // Menambahkan primary key pada kolom 'id_role'
        $this->forge->addKey('id_role', true);

        // Membuat tabel baru bernama 'role' dengan kolom yang telah didefinisikan di atas
        $this->forge->createTable('role');
    }

    // Metode 'down' untuk menghapus tabel atau kolom jika migrasi dibatalkan (rollback)
    public function down()
    {
        // Menghapus tabel 'role' dari database
        $this->forge->dropTable('role');
    }
}
