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
                'status_maintenance' => 'Sedang Maintenance',
            ],
            [
                'status_maintenance' => 'Selesai Maintenance',
            ],
            [
                'status_maintenance' => 'Membutuhkan Perbaikan',
            ],
        ];

        $builder->insertBatch($data);
    }
}
