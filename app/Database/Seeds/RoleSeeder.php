<?php
// Mendeklarasikan namespace 'App\Database\Seeds' agar seeder ini berada di dalam namespace aplikasi
namespace App\Database\Seeds;
// Menggunakan Seeder dari CodeIgniter untuk melakukan seeding database
use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    // Fungsi 'run' yang akan dijalankan ketika seeder dieksekusi
    public function run()
    {
        // Menghubungkan ke database menggunakan konfigurasi bawaan CodeIgniter
        $db      = \Config\Database::connect();
        
        // Membuat builder untuk tabel 'role' agar kita bisa melakukan operasi CRUD di tabel tersebut
        $builder = $db->table('role');

        // Data yang akan diinput ke dalam tabel 'role', di sini ada 3 role (Super Admin, Admin, dan User)
        $data = [
            [
                'user_role' => 'Super Admin', // Role 1: Super Admin
            ],
            [
                'user_role' => 'Admin', // Role 2: Admin
            ],
            [
                'user_role' => 'User', // Role 3: User
            ],
        ];

        // Menggunakan insertBatch untuk memasukkan banyak data sekaligus ke dalam tabel 'role'
        $builder->insertBatch($data);
    }
}
