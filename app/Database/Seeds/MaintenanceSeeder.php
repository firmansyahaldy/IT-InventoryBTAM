<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('maintenance');

        $data = [
            [
                'id_barang' => '2',
                'deskripsi' => 'Perbaikan kerusakan',
                'maintenance_selanjutnya' => '',
                'id_status_maintenance' => 1,
                'updated_at' => null,
                'maintened_by' => '',
            ],
        ];

        $builder->insertBatch($data);
    }
}
