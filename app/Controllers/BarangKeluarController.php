<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\BarangKeluarModel;
use App\Models\BarangModel;

class BarangKeluarController extends BaseController
{
    protected $barangKeluarModel;
    protected $barangModel;
    protected $session;

    public function __construct()
    {
        $this->barangKeluarModel = new BarangKeluarModel();
        $this->barangModel = new BarangModel(); // Untuk mendapatkan data barang
        $this->session = \config\Services::session();
    }


    protected function getUserRole()
    {
        return $this->session->get('role');
    }

    public function index()
    {
        $data = [
            'title' => 'Barang Keluar',
            'barangKeluar' => $this->barangKeluarModel->findAll(),
            'barang' => $this->barangModel->findAll(), // Dapatkan data barang untuk dropdown
        ];
        $data['userRole'] = $this->getUserRole();

        return view('barang_keluar', $data);
    }

    // Menyimpan data barang keluar
    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'id_barang' => 'required',
            'jumlah' => 'required|integer|greater_than[0]',
            'tanggal_keluar' => 'required|valid_date[Y-m-d]',
            'nama_penanggung_jawab' => 'required|max_length[50]',
            'alasan' => 'required|max_length[255]',
        ])) {
            // log_message('debug', 'Data yang dikirim: ' . print_r($this->request->getPost(), true));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Dapatkan informasi barang berdasarkan id_barang
        $barang = $this->barangModel->find($this->request->getPost('id_barang'));

        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }

        $jumlahKeluar = $this->request->getPost('jumlah');

        // Cek apakah stok barang mencukupi
        if ($barang['kuantitas'] < $jumlahKeluar) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        // Simpan data ke database
        $this->barangKeluarModel->save([
            'id_barang' => $this->request->getPost('id_barang'),
            'nama_barang' => $barang['nama_barang'],
            'jumlah' => $this->request->getPost('jumlah'),
            'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
            'nama_penanggung_jawab' => $this->request->getPost('nama_penanggung_jawab'),
            'alasan' => $this->request->getPost('alasan'),
            'status_pengembalian' => 'Belum Dikembalikan',
            'tanggal_pengembalian' => null
        ]);

        // Kurangi kuantitas barang di tabel barang
        $this->barangModel->update($this->request->getPost('id_barang'), [
            'kuantitas' => $barang['kuantitas'] - $jumlahKeluar,
        ]);

        return redirect()->to('dashboard/barang_keluar')->with('success', 'Data barang keluar berhasil ditambahkan');
    }

    // Fungsi untuk mengelola pengembalian barang
    public function returnItem($id_barang_keluar)
    {
        // Ambil data barang keluar berdasarkan ID
        $barangKeluar = $this->barangKeluarModel->find($id_barang_keluar);

        if (!$barangKeluar || $barangKeluar['status_pengembalian'] === 'Sudah Dikembalikan') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Barang sudah dikembalikan atau data tidak valid.'
            ]);
        }

        // Ambil data barang terkait
        $barang = $this->barangModel->find($barangKeluar['id_barang']);

        if (!$barang) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Barang tidak ditemukan.'
            ]);
        }

        // Tambahkan kembali kuantitas barang yang dikembalikan
        $this->barangModel->update($barangKeluar['id_barang'], [
            'kuantitas' => $barang['kuantitas'] + $barangKeluar['jumlah'],
        ]);

        // Update status pengembalian barang
        $this->barangKeluarModel->update($id_barang_keluar, [
            'status_pengembalian' => 'Sudah Dikembalikan', // Set status menjadi sudah dikembalikan
            'tanggal_kembali' => date('Y-m-d'), // Set tanggal kembali
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Barang berhasil dikembalikan.'
        ]);
    }

    public function getBarangKeluar($id_barang_keluar)
    {
        $barangKeluarModel = new BarangKeluarModel();
        $barangKeluar = $barangKeluarModel->find($id_barang_keluar);

        if ($barangKeluar) {
            return $this->response->setJSON($barangKeluar);
        } else {
            return $this->response->setStatusCode(404)->setBody('Barang Keluar tidak ditemukan');
        }
    }

    public function filter()
    {
        // Dapatkan tanggal mulai dan akhir dari request
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');

        // Validasi tanggal apakah tidak kosong
        if (!$tanggal_mulai || !$tanggal_akhir) {
            return redirect()->back()->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        // Debug: Tampilkan tanggal yang diterima
        // log_message('debug', 'Tanggal mulai: ' . $tanggal_mulai);
        // log_message('debug', 'Tanggal akhir: ' . $tanggal_akhir);

        // Dapatkan data barang keluar berdasarkan rentang tanggal
        $barangKeluar = $this->barangKeluarModel
            ->where('tanggal_keluar >=', $tanggal_mulai)
            ->where('tanggal_keluar <=', $tanggal_akhir)
            ->findAll();

        // Debug: Tampilkan jumlah data yang ditemukan
        // log_message('debug', 'Jumlah barang keluar yang ditemukan: ' . count($barangKeluar));

        // Dapatkan userRole (misalnya dari session atau database)
        $userRole = session()->get('userRole'); // Ambil userRole dari session, ini hanya contoh. Sesuaikan dengan cara Anda mengelola role.

        // Kirim data ke view
        return view('barang_keluar', [
            // 'barangKeluar' => $this->barangKeluarModel->findAll(),
            'userRole' => $userRole, // Jangan lupa mengirim variabel userRole
            'barang' => $this->barangModel->findAll(), // Dapatkan data barang untuk dropdown
            'barangKeluar' => $barangKeluar,
        ]);
    }

    public function getStok($id_barang)
    {
        // Cari barang berdasarkan id_barang
        $barang = $this->barangModel->find($id_barang);

        if ($barang) {
            log_message('debug', 'Barang ditemukan: ' . print_r($barang, true)); // Log untuk memeriksa barang
            return $this->response->setJSON([
                'success' => true,
                'stok' => $barang['kuantitas']
            ]);
        } else {
            log_message('debug', 'Barang tidak ditemukan'); // Log jika barang tidak ditemukan
            return $this->response->setJSON([
                'success' => false,
                'stok' => 0
            ]);
        }
    }
}
