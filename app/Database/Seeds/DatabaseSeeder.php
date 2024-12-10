<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('RoleSeeder');
        $this->call('JabatanSeeder');
        $this->call('KategoriSeeder');
        $this->call('KondisiSeeder');
        $this->call('StatusBarangSeeder');
        $this->call('LokasiBarangSeeder');
        $this->call('StatusMaintenanceSeeder');
        $this->call('UserSeeder');
        $this->call('BarangSeeder');
    }
}
