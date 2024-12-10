<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('jabatan');

        $data = [
            [
                'nama_jabatan' => 'Anak Magang',
            ],
            [
                'nama_jabatan' => 'Kepala IT',
            ],
        ];

        $builder->insertBatch($data);
    }
}
