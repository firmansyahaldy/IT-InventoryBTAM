<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class StatusMaintenanceSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('status_maintenance');

        $data = [
            [
                'status_maintenance' => 'Pendding',
            ],
            [
                'status_maintenance' => 'Sedang Proses',
            ],
            [
                'status_maintenance' => 'Selesai Pemeliharaan',
            ],
            [
                'status_maintenance' => 'Membutuhkan Perbaikan',
            ],
            [
                'status_maintenance' => 'Tidak Bisa Diperbaiki',
            ],
        ];

        $builder->insertBatch($data);
    }
}
