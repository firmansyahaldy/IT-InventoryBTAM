<?php
namespace App\Controllers;
use App\Controllers\BaseController;
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
        $userModel = new \App\Models\UserModel(); // Model untuk data user
        $maintenanceModel = new \App\Models\MaintenanceModel(); // Model untuk data maintenance

        // Menghitung total item di tabel barang
        $totalItem = $barangModel->countAllResults();

        // Menghitung total user di tabel user
        $totalUser = $userModel->countAllResults();

        // Menghitung total maintenance yang belum selesai berdasarkan status maintenance
        $totalMaintenance = $maintenanceModel
            ->join('status_maintenance', 'maintenance.id_status_maintenance = status_maintenance.id_status_maintenance')
            ->where('status_maintenance.status_maintenance !=', 'Selesai Maintenance')
            ->countAllResults();

        // Mengambil data kondisi barang dari model
        $kondisiBarang = $barangModel->getKondisiBarang();

        // Menyiapkan data yang akan dikirimkan ke view dashboard
        $data = [
            'totalItem' => $totalItem, // Total barang
            'totalUser' => $totalUser, // Total user
            'totalMaintenance' => $totalMaintenance, // Total maintenance yang belum selesai
            'kondisiBarang' => $kondisiBarang, // Kondisi barang
            'userRole' => $userRole
        ];

        // Mengirimkan data ke view 'dashboard' dan menambahkan data pending maintenance
        return view('dashboard', $data);
    }
}
