<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BarangKeluarSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('barang_keluar');

        $data = [
            [
                'id_barang' => '2',
                'nama_barang' => 'Perbaikan kerusakan',
                'jumlah' => '',
                'tanggal_keluar' => 1,
                'nama_penanggung_jawab' => '',
                'alasan' => '',
                'status_pengembalian' => 'Belum dikembalikan',
                'tanggal_kembali' => null,
            ],
        ];

        $builder->insertBatch($data);
    }
}
