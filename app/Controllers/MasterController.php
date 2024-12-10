<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoleModel;
use App\Models\KategoriModel;
use App\Models\KondisiModel;
use App\Models\LokasiBarangModel;
use App\Models\StatusBarangModel;
use App\Models\StatusMaintenanceModel;

use function PHPUnit\Framework\returnSelf;

class MasterController extends BaseController
{
    // Method ini menampilkan daftar user
    public function index()
    {
        // Inisialisasi session untuk mengambil role user yang sedang login
        $session = \config\Services::session();
        $userRole = $session->get('role'); // Ambil role dari session

        // Inisialisasi Model
        $roleModel = new RoleModel();
        $kategoriModel = new KategoriModel();
        $kondisiModel = new KondisiModel();
        $lokasiModel = new LokasiBarangModel();
        $statusMaintenanceModel = new StatusMaintenanceModel();
        $statusBarangModel = new StatusBarangModel();
        $jabatanModel = new JabatanModel();

        // Ambil semua data role dari tabel role
        $data['roles'] = $roleModel->findAll();
        $data['kategoris'] = $kategoriModel->findAll();
        $data['kondisis'] = $kondisiModel->findAll();
        $data['lokasis'] = $lokasiModel->findAll();
        $data['statusmaintenances'] = $statusMaintenanceModel->findAll();
        $data['statusbarangs'] = $statusBarangModel->findAll();
        $data['jabatans'] = $jabatanModel->findAll();

        // Simpan role user yang sedang login ke variabel 'userRole'
        $data['userRole'] = $userRole;

        // Kembalikan tampilan halaman user dengan data users dan userRole
        return view('data_master', $data);
    }

    public function getModel($table)
    {
        switch ($table) {
            case 'role':
                return new \App\Models\RoleModel();
            case 'kategori':
                return new \App\Models\KategoriModel();
            case 'kondisi':
                return new \App\Models\KondisiModel();
            case 'lokasi':
                return new \App\Models\LokasiBarangModel();
            case 'statusMaintenance':
                return new \App\Models\StatusMaintenanceModel();
            case 'statusBarang':
                return new \App\Models\StatusBarangModel();
            case 'jabatan':
                return new \App\Models\JabatanModel();
            default:
                throw new \Exception("Model untuk tabel $table tidak ditemukan");
        }
    }

    public function create($table)
    {
        $model = $this->getModel($table); // Mendapatkan model berdasarkan nama tabel
        $data = $this->request->getPost();

        // Cek data yang akan di-insert
        log_message('debug', 'Data yang akan diinsert: ' . json_encode($data));

        if ($model->insert($data)) {
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } else {
            // Menampilkan error dari model
            $errors = $model->errors();
            log_message('error', 'Error insert: ' . json_encode($errors));

            return redirect()->back()->with('error', 'Gagal menambahkan data');
        }
    }

    public function update($table, $id)
    {
        $model = $this->getModel($table);
        $data = $this->request->getPost();
        if ($model->update($id, $data)) {
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate data');
        }
    }

    public function delete($table, $id)
    {
        $model = $this->getModel($table);
        if ($model->delete($id)) {
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }
    }

    public function get($table, $id)
    {
        $model = $this->getModel($table); // Ambil model sesuai tabel
        $data = $model->find($id); // Cari data berdasarkan ID

        if ($data) {
            return $this->response->setJSON($data); // Kembalikan data dalam format JSON
        }

        return $this->response->setStatusCode(404, 'Data tidak ditemukan');
    }
}
