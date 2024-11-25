<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    /**
     * Menampilkan halaman login.
     * Method ini memuat tampilan halaman login saat user mengunjungi URL login.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        return view('auth/login'); // Menampilkan halaman login
    }

    /**
     * Memproses login user.
     * Method ini menerima input dari form login, memvalidasi data, dan mengecek kecocokan username dan password.
     * Jika berhasil, user akan diarahkan ke dashboard. Jika gagal, user akan dikembalikan ke halaman login dengan pesan error.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function login()
    {
        // Mengambil model user untuk melakukan query pada tabel user
        $userModel = new \App\Models\UserModel();

        // Mengambil username dan password dari input POST
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Memulai session untuk menyimpan informasi user saat login
        $session = session();
        $userModel = new UserModel();

        // Aturan validasi untuk memastikan username dan password tidak kosong
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        // Jika validasi gagal, redirect kembali ke halaman login dengan pesan error
        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors(); // Ambil error validasi
            log_message('error', 'Validation failed: ' . json_encode($errors)); // Catat error ke log
            return redirect()->back()->with('error', 'Validasi gagal.')->withInput(); // Redirect dengan pesan error
        }

        // Mengambil username dan password yang divalidasi dari input POST
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Mengecek apakah user dengan username tersebut ada di database
        $user = $userModel->where('username', $username)->first();
        $user = $userModel->getUserWithRole($username); // Mengambil user dengan join pada tabel role

        // Periksa apakah user ditemukan
        if ($user !== null) {
            // Proses login
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id_user'   => $user['id_user'],
                    'username'  => $user['username'],
                    'role'      => $user['user_role'], // role yang diperoleh dari tabel role
                    'logged_in' => true,
                    'login_time' => time()
                ];
                $session->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                // Password salah
                return redirect()->back()->with('error', 'Password salah');
            }
        } else {
            // User tidak ditemukan
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }
    }

    /**
     * Logout user.
     * Method ini menghancurkan session yang sedang aktif dan mengarahkan user kembali ke halaman login.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function logout()
    {
        // Menginisiasi session
        $session = session();
        // Menghapus seluruh data session untuk user yang sedang login
        $session->destroy();
        // Redirect ke halaman login setelah logout
        return redirect()->to('/auth/login');
    }
}
