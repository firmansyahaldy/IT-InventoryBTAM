<?php

namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('barang');
        $data = [
            [
                'kode_barang' => 1,
                'id_kategori' => 7,
                'nama_barang' => 'Laptop Dell XPS 13',
                'merk' => 'Dell',
                'spesifikasi' => 'Intel Core i7, 16GB RAM, 512GB SSD',
                'tipe' => 'Laptop',
                'tgl_pembelian' => '2023-01-15',
                'harga_pembelian' => 20000000,
                'id_status_barang' => 1,
                'kuantitas' => 10,
                'id_kondisi' => 1,
                'masa_garansi' => '2025-01-15',
                'serial_number' => 'SN123456789',
                'id_lokasi_barang' => 1,
                'maintenance_selanjutnya' => date('Y-m-d', strtotime('+1 year')),
            ],
            [
                'kode_barang' => 2,
                'id_kategori' => 11,
                'nama_barang' => 'Printer HP LaserJet Pro',
                'merk' => 'HP',
                'spesifikasi' => 'LaserJet, A4, Monochrome',
                'tipe' => 'Printer',
                'tgl_pembelian' => '2022-10-10',
                'harga_pembelian' => 3000000,
                'id_status_barang' => 1,
                'kuantitas' => 5,
                'id_kondisi' => 1,
                'masa_garansi' => '2024-10-10',
                'serial_number' => 'SN987654321',
                'id_lokasi_barang' => 2,
                'maintenance_selanjutnya' => date('Y-m-d', strtotime('+1 year')),
            ],
        ];
        $builder->insertBatch($data);
    }
}
