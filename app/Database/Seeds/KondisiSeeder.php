<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KondisiSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('kondisi');

        $data = [
            [
                'kondisi_item' => 'Baik',
            ],
            [
                'kondisi_item' => 'Rusak',
            ],
            [
                'kondisi_item' => 'Habis Masa Pakai',
            ],
        ];

        $builder->insertBatch($data);
    }
}
