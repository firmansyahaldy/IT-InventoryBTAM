<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StatusBarangSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('status_barang');

        $data = [
            [
                'status_barang' => 'BMN',
            ],
            [
                'status_barang' => 'Non-BMN',
            ],
        ];

        $builder->insertBatch($data);
    }
}
