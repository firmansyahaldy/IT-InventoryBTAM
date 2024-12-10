<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MaintenanceModel;

class DashboardController extends BaseController
{
    /**
     * Method untuk menampilkan halaman dashboard dengan berbagai data statistik.
     * Menghitung total item, user, maintenance, dan biaya per bulan.
     */
    public function index()
    {
        $session = \config\Services::session();
        $userRole = $session->get('role'); // Ambil role dari session
        $barangModel  = new \App\Models\BarangModel(); // Model untuk data barang
        $barangKeluarModel = new \App\Models\BarangKeluarModel(); // Model untuk data barang keluar
        $userModel = new \App\Models\UserModel(); // Model untuk data user
        $maintenanceModel = new \App\Models\MaintenanceModel(); // Model untuk data maintenance
        $stackedBarChartData = $barangModel->getStackedBarChartData();

        // Menghitung total item di tabel barang
        $totalItem = $barangModel->countAllResults();

        // Menghitung total user di tabel user
        $totalUser = $userModel->countAllResults();

        // Menghitung total maintenance yang belum selesai berdasarkan status maintenance
        $totalMaintenance = $maintenanceModel
            ->join('status_maintenance', 'maintenance.id_status_maintenance = status_maintenance.id_status_maintenance')
            ->where('status_maintenance.status_maintenance !=', 'Selesai Maintenance')
            ->countAllResults();

        // Mengambil data barang dari model
        $kondisiBarang = $barangModel->getKondisiBarang();
        $barangKeluarData = $barangKeluarModel->getBarangKeluarData();

        // Menyiapkan data yang akan dikirimkan ke view dashboard
        $data = [
            'totalItem' => $totalItem,
            'totalUser' => $totalUser,
            'totalMaintenance' => $totalMaintenance,
            'kondisiBarang' => $kondisiBarang, // Data kondisi barang
            'barangKeluarData' => $barangKeluarData,
            'userRole' => $userRole,
            'stackedBarChartData' => $stackedBarChartData,
        ];

        // Mengirimkan data ke view 'dashboard' dan menambahkan data pending maintenance
        return view('dashboard', $data);
    }

    public function getPieChartData()
    {
        $barangKeluarModel = new \App\Models\BarangKeluarModel();

        // Query untuk mendapatkan data status pengembalian
        $data = $barangKeluarModel->select('status_pengembalian, COUNT(*) as jumlah')
            ->groupBy('status_pengembalian')
            ->findAll();

        // Format data untuk Chart.js
        $chartData = [
            'labels' => array_column($data, 'status_pengembalian'),
            'datasets' => [
                [
                    'data' => array_column($data, 'jumlah'),
                    'backgroundColor' => ['#FF6384', '#36A2EB'], // Warna pie chart
                ]
            ]
        ];

        // Debug respons JSON
        log_message('debug', 'Data Chart: ' . json_encode($chartData));

        return $this->response->setJSON($chartData);
    }


}
