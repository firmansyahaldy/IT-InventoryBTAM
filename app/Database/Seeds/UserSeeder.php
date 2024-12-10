<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $data = [
            [
                'username' => 'aldy',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'nama_user' => 'aldy firmansyah',
                'id_jabatan' => '1',
                'id_role' => '1',
            ],
            [
                'username' => 'eri',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'nama_user' => 'eri engel',
                'id_jabatan' => '1',
                'id_role' => '2',
            ],
            [
                'username' => 'udin',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'nama_user' => 'udin petot',
                'id_jabatan' => '2',
                'id_role' => '3',
            ],
        ];
        $builder->insertBatch($data);
    }
}
