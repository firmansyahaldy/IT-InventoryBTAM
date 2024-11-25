<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\MaintenanceModel;

class BarangController extends BaseController
{
    protected $barangModel;
    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    /**
     * Menampilkan semua barang.
     * Method ini mengambil semua data barang dari database dan menampilkan ke dalam view.
     */
    public function index()
    {
        $session = \config\Services::session();
        $userRole = $session->get('role'); // Ambil role dari session

        $roleModel = new \App\Models\RoleModel(); // RoleModel
        $barangModel = new BarangModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $statusBarang = new \App\Models\StatusBarangModel();
        $kondisiBarang = new \App\Models\KondisiModel();
        $lokasiBarang = new \App\Models\LokasiBarangModel();

        $data['barangs'] = $barangModel->select('barang.*, kategori.kategori_item, status_barang.status_barang, kondisi.kondisi_item, lokasi_barang.lokasi_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->join('status_barang', 'status_barang.id_status_barang = barang.id_status_barang')
            ->join('kondisi', 'kondisi.id_kondisi = barang.id_kondisi')
            ->join('lokasi_barang', 'lokasi_barang.id_lokasi_barang = barang.id_lokasi_barang')
            ->findAll();

        $data['roles'] = $roleModel->findAll();
        $data['userRole'] = $userRole; // Kirim role user ke view
        $data['kategoris'] = $kategoriModel->findAll();
        $data['statusBarangs'] = $statusBarang->findAll();
        $data['kondisiBarangs'] = $kondisiBarang->findAll();
        $data['lokasiBarangs'] = $lokasiBarang->findAll();

        return view('barang', $data); // Tampilkan data ke halaman view 'barang'
    }

    /**
     * Menambahkan barang baru.
     * Method ini memproses input dari form untuk menambahkan barang ke dalam database.
     */
    public function create()
    {
        $barangModel = new BarangModel();
        // Ambil data dari form
        $data = [
            'kode_barang' => $this->request->getPost('kode_barang'),
            'id_kategori' => $this->request->getPost('kategori'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'merk' => $this->request->getPost('merk'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'tipe' => $this->request->getPost('tipe'),
            'tgl_pembelian' => $this->request->getPost('tgl_pembelian'),
            'harga_pembelian' => $this->request->getPost('harga_pembelian'),
            'id_status_barang' => $this->request->getPost('status_barang'),
            'kuantitas' => $this->request->getPost('kuantitas'),
            'id_kondisi' => $this->request->getPost('kondisi_barang'),
            'masa_garansi' => $this->request->getPost('masa_garansi'),
            'serial_number' => $this->request->getPost('serial_number'),
            'id_lokasi_barang' => $this->request->getPost('lokasi_barang'),
            'maintenance_selanjutnya' => $this->request->getPost('maintenance_selanjutnya'),
        ];
        // Jika berhasil menambah barang, redirect ke halaman barang dengan pesan sukses
        if ($barangModel->insert($data)) {
            // log_message('info', 'Barang berhasil ditambahkan ke database.');
            return redirect()->to('/dashboard/barang')->with('success', 'Barang berhasil ditambahkan.');
        } else {
            // Debugging: tampilkan error dari model
            $errors = $barangModel->errors();

            // Debugging: tampilkan error ke halaman
            return redirect()->back()->with('error', 'Gagal menambahkan barang. Error: ' . implode(', ', $errors));
        }
    }

    /**
     * Menghapus barang berdasarkan kode_barang.
     * Method ini menghapus barang dari database dengan kode_barang yang diberikan.
     */
    public function delete($id_barang)
    {
        $barangModel = new BarangModel();
        // Jika barang berhasil dihapus, redirect ke halaman barang dengan pesan sukses
        if ($barangModel->delete($id_barang)) {
            return redirect()->to('/dashboard/barang')->with('success', 'Barang berhasil dihapus.');
        } else {
            // Jika gagal, redirect dengan pesan error
            return redirect()->to('/dashboard/barang')->with('error', 'Gagal menghapus barang.');
        }
    }

    /**
     * Mengambil data barang berdasarkan id_barang.
     * Method ini digunakan untuk mendapatkan data barang dengan format JSON.
     */
    public function getBarang($id_barang)
    {
        $barangModel = new BarangModel();
        $barang = $barangModel->find($id_barang); // Cari barang berdasarkan id_barang
        if ($barang) {
            return $this->response->setJSON($barang); // Kembalikan data barang dalam format JSON
        } else {
            // Jika barang tidak ditemukan, kembalikan response dengan status 404
            return $this->response->setStatusCode(404)->setBody('Barang not found');
        }
    }

    /**
     * Menambahkan data maintenance.
     * Method ini menambahkan entri maintenance baru ke dalam tabel maintenance.
     */
    private function updateMaintenance($id_barang, $kode_barang, $deskripsi_kerusakan)
    {
        $maintenanceModel = new MaintenanceModel();
        $barangModel = new BarangModel(); // Pastikan Anda memiliki model untuk tabel barang
        // Ambil nilai maintenance_selanjutnya dari tabel barang
        $barangData = $barangModel->select('maintenance_selanjutnya')
            ->where('id_barang', $id_barang)
            ->first();
        // Jika data barang ditemukan, ambil nilai maintenance_selanjutnya
        if ($barangData) {
            $maintenanceSelanjutnya = $barangData['maintenance_selanjutnya'];
        } else {
            // Jika tidak ditemukan, catat log dan return false
            // log_message('error', 'Barang with id_barang ' . $id_barang . ' not found');
            return false;
        }

        // Data maintenance yang akan dimasukkan
        $maintenanceData = [
            'id_barang' => $id_barang,
            'kode_barang' => $kode_barang,
            'deskripsi' => $deskripsi_kerusakan,
            'maintenance_selanjutnya' => $maintenanceSelanjutnya, // Gunakan nilai dari tabel barang
            'id_status_maintenance' => 1,
            'updated_at' => null,
            'maintened_by' => null
        ];

        // Jika berhasil menambah data maintenance, kembalikan true
        if ($maintenanceModel->insert($maintenanceData)) {
            // log_message('info', 'Data added to maintenance table successfully');
            return true;
        } else {
            // Jika gagal, catat log dan kembalikan false
            // log_message('error', 'Failed to add data to maintenance table');
            // log_message('error', 'Error details: ' . print_r($maintenanceModel->errors(), true));
            return false;
        }
    }


    /**
     * Mengupdate data barang berdasarkan kode_barang.
     * Method ini mengupdate data barang yang sudah ada di database.
     */
    private function updateBarang($id_barang, $data)
    {
        $barangModel = new BarangModel();
        // Jika berhasil mengupdate barang, kembalikan true
        if ($barangModel->update($id_barang, $data)) {
            return true;
        } else {
            // Jika gagal, catat log dan kembalikan false
            // log_message('error', 'Failed to update barang with id_barang: ' . $id_barang);
            // log_message('error', 'Error details: ' . print_r($barangModel->errors(), true));
            return false;
        }
    }

    /**
     * Mengupdate data barang dan maintenance jika diperlukan.
     * Method ini akan mengupdate barang dan menambahkan maintenance jika kondisi barang rusak.
     */
    public function update()
    {
        $kode_barang = $this->request->getPost('kode_barang');
        $kondisi_barang = $this->request->getPost('kondisi_barang');
        $kategori = $this->request->getPost('kategori');
        $maintenance_selanjutnya = $this->request->getPost('maintenance_selanjutnya');
        $id_barang = $this->request->getPost('id_barang');

        // Data yang akan diupdate
        $data = [
            // 'kode_barang' => $kode_barang,
            'id_kategori' => $kategori,
            'id_kondisi' => $kondisi_barang,
            'id_lokasi_barang' => $this->request->getPost('lokasi_barang'),
            'maintenance_selanjutnya' => $maintenance_selanjutnya,
        ];
        // log_message('debug', 'Data yang dikirim: ' . print_r($this->request->getPost(), true));

        // Update barang
        $isBarangUpdated = $this->updateBarang($id_barang, $data);
        // Debugging: tampilkan data yang akan dimasukkan
        // log_message('debug', 'Data yang akan diupdate: ' . print_r($data, true));

        // Jika kondisi barang rusak, tambahkan data ke tabel maintenance
        if ($kondisi_barang == 2) {
            $deskripsi_kerusakan = $this->request->getPost('deskripsi_kerusakan');
            $isMaintenanceUpdated = $this->updateMaintenance($id_barang, $kode_barang, $deskripsi_kerusakan);
        } else {
            $isMaintenanceUpdated = true; // Jika tidak rusak, tidak perlu update maintenance
        }

        // Cek apakah proses update barang dan maintenance berhasil
        if ($isBarangUpdated && $isMaintenanceUpdated) {
            return redirect()->to('/dashboard/barang')->with('success', 'Barang berhasil diupdate.');
        } else {
            // Jika salah satu proses gagal, tampilkan pesan error

            return redirect()->back()->with('error', 'Gagal mengupdate barang atau maintenance.');
        }
    }
}
