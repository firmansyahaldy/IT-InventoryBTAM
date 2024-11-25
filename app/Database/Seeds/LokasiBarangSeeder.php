<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LokasiBarangSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('lokasi_barang');

        $data = [
            [
                'lokasi_barang' => 'Ruang TU',
            ],
            [
                'lokasi_barang' => 'Ruang BIMTEK',
            ],
            [
                'lokasi_barang' => 'Laboratorium',
            ],
        ];

        $builder->insertBatch($data);
    }
}
