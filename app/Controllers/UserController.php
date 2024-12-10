<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use CodeIgniter\HTTP\ResponseInterface;

// Mengimpor model yang digunakan
use App\Models\UserModel;
use App\Models\RoleModel;

// Mendeklarasikan class UserController yang merupakan turunan dari BaseController
class UserController extends BaseController
{
    // Mendeklarasikan properti untuk menyimpan instance model dan session
    protected $userModel;
    protected $roleModel;
    protected $jabatanModel;
    protected $session;

    // Konstruktor untuk menginisialisasi model dan session
    public function __construct()
    {
        // Membuat instance UserModel
        $this->userModel = new UserModel();
        // Membuat instance RoleModel
        $this->roleModel = new RoleModel();
        // Membuat instance JabatanModel
        $this->jabatanModel = new JabatanModel();
        // Menginisialisasi session
        $this->session = \config\Services::session();
    }

    // Method untuk mendapatkan peran user dari session
    protected function getUserRole()
    {
        // Mengambil role user yang tersimpan di session
        return $this->session->get('role');
    }

    // Method ini untuk menampilkan daftar user
    public function index()
    {
        // Mengambil data user beserta rolenya
        $data['users'] = $this->userModel->getUsersWithRoles();
        // Mengambil semua data role dari database
        $data['roles'] = $this->roleModel->findAll();
        // Mengambil role user yang tersimpan di session
        $data['userRole'] = $this->getUserRole();
        // Mengambil semua data jabatan dari database
        $data['jabatans'] = $this->jabatanModel->findAll();
        // Menampilkan view user dan mengirimkan data yang dibutuhkan
        return view('user', $data);
    }

    // Method ini digunakan untuk menambahkan user baru
    public function create()
    {
        // Membuat instance UserModel
        $userModel = new \App\Models\UserModel();
        // Mengambil data yang diinputkan dari form untuk user baru
        $data = [
            'username' => $this->request->getPost('username'), // Mengambil input username
            'nama_user' => $this->request->getPost('nama_user'), // Mengambil input nama user
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Meng-hash password sebelum disimpan
            'id_role' => $this->request->getPost('role'), // Mengambil role user dari form
            'id_jabatan' => $this->request->getPost('jabatan'), // Mengambil jabatan user dari form
        ];
        // Menyimpan data user baru ke database
        if ($userModel->insert($data)) {
            // Jika berhasil, redirect ke halaman daftar user dengan pesan sukses
            return redirect()->to('/dashboard/user')->with('success', 'User berhasil ditambahkan.');
        } else {
            // Jika gagal, redirect kembali ke form dengan pesan error
            return redirect()->back()->with('error', 'Gagal menambahkan user.');
        }
    }

    // Method untuk mengupdate data user
    public function update()
    {
        $id_user = $this->request->getPost('id_user');
        $nama_user = $this->request->getPost('edit_nama_user');
        $role = $this->request->getPost('edit_role');
        $jabatan = $this->request->getPost('edit_jabatan');

        // Ambil password baru dari input
        $password = $this->request->getPost('edit_password');

        // Ambil data user lama
        $user = $this->userModel->find($id_user);

        if ($password) {
            // Jika password baru diberikan, hash sebelum menyimpan
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Jika tidak, gunakan password lama
            $hashedPassword = $user['password'];
        }

        // Update data user
        $this->userModel->update($id_user, [
            'nama_user' => $nama_user,
            'id_role' => $role,
            'id_jabatan' => $jabatan,
            'password' => $hashedPassword,
        ]);

        return redirect()->to('/dashboard/user')->with('success', 'User berhasil diperbarui.');
    }

    // Method untuk menghapus user berdasarkan ID user
    public function delete($id_user)
    {
        // Membuat instance UserModel
        $userModel = new UserModel();
        // Mencari user berdasarkan ID yang diberikan
        $user = $userModel->find($id_user);
        // Jika user ditemukan, lanjutkan dengan penghapusan
        if ($user) {
            // Hapus user dari database
            if ($userModel->delete($id_user)) {
                // Jika berhasil, redirect ke halaman daftar user dengan pesan sukses
                return redirect()->to('/dashboard/user')->with('success', 'User berhasil dihapus.');
            } else {
                // Jika gagal menghapus, tampilkan pesan error
                return redirect()->to('/dashboard/user')->with('error', 'Gagal menghapus user.');
            }
        } else {
            // Jika user tidak ditemukan, tampilkan pesan error
            return redirect()->to('/dashboard/user')->with('error', 'User tidak ditemukan.');
        }
    }

    // Method untuk mendapatkan data user berdasarkan ID user
    public function getUser($id_user)
    {
        // Ambil data user lengkap dari model
        $user = $this->userModel->getUser($id_user);

        if ($user) {
            return $this->response->setJSON($user); // Kirimkan data user dalam format JSON
        } else {
            return $this->response->setStatusCode(404)->setBody('User not found');
        }
    }
}
