<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('kategori');

        $data = [
            [
                'kategori_item' => 'Mouse',
            ],
            [
                'kategori_item' => 'Keyboard',
            ],
            [
                'kategori_item' => 'Monitor',
            ],
            [
                'kategori_item' => 'Proyektor',
            ],
            [
                'kategori_item' => 'Headset/Headphone',
            ],
            [
                'kategori_item' => 'Kamera Digital',
            ],
            [
                'kategori_item' => 'PC/Laptop',
            ],
            [
                'kategori_item' => 'Server',
            ],
            [
                'kategori_item' => 'Switch/Hub',
            ],
            [
                'kategori_item' => 'Camera Conference/Webcam',
            ],
            [
                'kategori_item' => 'Printer',
            ],
            [
                'kategori_item' => 'Scanner',
            ],
            [
                'kategori_item' => 'Access Point',
            ],
        ];

        $builder->insertBatch($data);
    }
}
