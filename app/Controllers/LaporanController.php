<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \Mpdf\Mpdf;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanController extends BaseController
{
    // Inisialisasi session
    protected $session;

    // Konstruktor untuk menginisialisasi session
    public function __construct()
    {
        $this->session = \config\Services::session();
    }

    // Mendapatkan peran pengguna dari session
    protected function getUserRole()
    {
        return $this->session->get('role');
    }

    // Menampilkan halaman laporan dengan daftar tabel dan peran pengguna
    public function index()
    {
        // Inisialisasi model
        $userModel = new UserModel();

        // Panggil fungsi getUsersWithRoles
        $users = $userModel->getUsersWithRoles();

        // Menyiapkan data untuk dikirim ke view
        $data = [
            'tables' => ['user', 'data barang', 'pemeliharaan', 'barang-keluar', 'pengembalian-barang', 'rekap kondisi barang'],
            'userRole' => $this->getUserRole(),
            'users' => $users, // Tambahkan data users
        ];

        // Kirim data ke view
        return view('laporan_view', $data);
    }


    // Fungsi untuk mengambil data berdasarkan tabel yang dipilih
    public function getData($table)
    {
        $model = new LaporanModel(); // Membuat instance dari model laporan
        $data = [];

        // Kondisi untuk memproses pengambilan data sesuai tabel yang dipilih
        if ($table == 'barang-keluar') {
            // Ambil filter tanggal dari request
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');

            // Ambil data barang keluar berdasarkan tanggal
            $data = $model->getBarangKeluarDataByDate($startDate, $endDate);
        } elseif ($table == 'user') {
            // Ambil data user
            $data = $model->getUserData();
        } elseif ($table == 'data barang') {
            // Ambil data barang
            $data = $model->getBarangData();
        } elseif ($table == 'pemeliharaan') {
            // Ambil data maintenance
            $data = $model->getMaintenanceData();
        } elseif ($table == 'pengembalian-barang') {
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');
            $data = $model->returnBarang($startDate, $endDate);
        } elseif ($table == 'rekap kondisi barang') {
            $data = $model->getBarangDataWithConditions();
        }

        // Mengembalikan data dalam format JSON
        return $this->response->setJSON($data);
    }

    // Fungsi untuk ekspor data ke format yang diinginkan (PDF atau Excel)
    public function export($table, $format)
    {
        $model = new LaporanModel(); // Instance model
        $data = []; // Inisialisasi data

        // Ambil data berdasarkan tabel yang dipilih
        if ($table === 'pengembalian-barang') {
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');

            // Ambil data hanya berdasarkan tanggal
            $data = $model->returnBarang($startDate, $endDate);
        } elseif ($table === 'barang-keluar') {
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');

            // Ambil data hanya berdasarkan tanggal
            $data = $model->getBarangKeluarDataByDate($startDate, $endDate);
        } elseif ($table === 'user') {
            $data = $model->getUserData();
        } elseif ($table === 'rekap kondisi barang') {
            // $data = $model->getBarangData();
            $data = $model->getBarangDataWithConditions();
        } elseif ($table === 'pemeliharaan') {
            $data = $model->getMaintenanceData();
        } elseif ($table === 'data barang') {
            $data = $model->getBarangData();
        }

        if (empty($data)) {
            return redirect()->to('/dashboard/cetak_laporan')->with('error', 'Tidak ada data pada tanggal yang anda pilih.');
        }

        // Generate file sesuai format
        $filename = $table . '_report_' . date('Y-m-d') . ($format === 'excel' ? '.xlsx' : '.pdf');
        if ($format === 'excel') {
            $this->generateExcel($data, $filename);
        } elseif ($format === 'pdf') {
            // PDF membutuhkan parameter tambahan
            $peminjam = $this->request->getGet('peminjam');
            $jabatan = $this->request->getGet('jabatan');
            $alamatTujuan = $this->request->getGet('alamatTujuan');
            $keperluan = $this->request->getGet('keperluan');
            $hp = $this->request->getGet('hp');

            // Ambil nama_user dari database jika parameter peminjam tersedia
            $namaUser = 'Unknown'; // Default jika tidak ditemukan
            if (!empty($peminjam)) {
                $userModel = new UserModel();
                $user = $userModel->find($peminjam);
                if (!empty($user)) {
                    $namaUser = $user['nama_user'];
                }
            }

            // Panggil fungsi generatePDF dengan nama_user
            $this->generatePDF($data, $filename, $table, date('Y-m-d'), $alamatTujuan, $namaUser, $jabatan, $keperluan, $hp);
        }
    }

    // Fungsi untuk generate file PDF
    private function generatePDF($data, $filename, $tableName, $printDate, $alamatTujuan = '', $namaUser = '', $jabatan = '', $keperluan = '', $hp = '')
    {
        // Meningkatkan batas waktu eksekusi dan memori
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        // Inisialisasi Mpdf dengan pengaturan margin
        if ($tableName == 'data barang') {
            // Ubah orientasi kertas menjadi landscape
            $mpdf = new \Mpdf\Mpdf([
                'margin_top' => 10,
                'margin_right' => 10,
                'margin_bottom' => 20,
                'margin_left' => 10,
                'orientation' => 'L', // Tambahkan opsi ini untuk landscape
            ]);
        } else {
            // Orientasi potret untuk tabel lainnya
            $mpdf = new \Mpdf\Mpdf([
                'margin_top' => 10,
                'margin_right' => 10,
                'margin_bottom' => 20,
                'margin_left' => 10,
            ]);
        }

        //     // Header dokumen
        //     $kopSurat = '
        // <div style="text-align: center;">
        //     <p>Format Formulir Peminjaman dan Pengembalian Alat/Barang/Bahan</p>
        //     <p>(F-13/SOP/OP/17 Rev.00)</p>
        // </div>';
        //     $mpdf->SetHTMLHeader($kopSurat);

        // CSS untuk style dokumen
        $css = '
        h1 { font-size: 12pt; text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { font-size: 10pt; padding: 5px; text-align: center; border: 1px solid black; }
        p { font-size: 12pt; margin: 10px 0; }
        ';

        // Mulai pembuatan HTML
        $html = '';

        // Jika tableName adalah 'barang-keluar', buat format surat jalan
        if ($tableName == 'barang-keluar') {
            // Membuat konten
            $html .= '<p style="text-align: center; font-weight: bold;">Lampiran 13</p>';
            $html .= '<p style="text-align: center; font-weight: bold;">Format Formulir Peminjaman dan Pengembalian Alat/Barang/Bahan</p>';
            $html .= '<p style="text-align: center;">(F-13/SOP/OP/17 Rev.00)</p>';
            $html .= '<h1>PEMINJAMAN BARANG</h1>';
            $html .= '<p>Yang bertanda tangan di bawah ini:</p>';
            $html .= '<p>Nama: ' . htmlspecialchars($namaUser, ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>Jabatan: ' . htmlspecialchars($jabatan, ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>No. HP: ' . htmlspecialchars($hp, ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>Instansi: Balai Teknologi Air Minum</p>';
            $html .= '<p>Alamat: Jl. Chairil Anwar I No. 1</p>';
            $html .= '<p>Tujuan: ' . htmlspecialchars($alamatTujuan, ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>Untuk keperluan: ' . htmlspecialchars($keperluan, ENT_QUOTES, 'UTF-8') . '</p>';
        } elseif ($tableName != 'pengembalian-barang' && $tableName != 'barang-keluar') {
            // Judul laporan umum
            $html .= '<h1>Data Inventaris infrastruktur IT</h1>';
            $html .= '<p>Jenis Data : Data ' . htmlspecialchars(ucfirst($tableName), ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>Tanggal Cetak : ' . date('d F Y', strtotime($printDate)) . '</p>';
        } elseif ($tableName == 'pengembalian-barang') {
            // Judul laporan pengembalian barang
            $html .= '<p style="text-align: center; font-weight: bold;">Lampiran 13</p>';
            $html .= '<p style="text-align: center; font-weight: bold;">Format Formulir Peminjaman dan Pengembalian Alat/Barang/Bahan</p>';
            $html .= '<p style="text-align: center;">(F-13/SOP/OP/17 Rev.00)</p>';
            $html .= '<h1>PENGEMBALIAN BARANG</h1>';
        }
        

        // Membuat tabel data
        $html .= '<table>';

        // Membuat header tabel
        if (!empty($data)) {
            $html .= '<thead><tr><th>No</th>';
            foreach (array_keys($data[0]) as $header) {
                if ($header !== 'id') { // Menghilangkan kolom 'id'
                    $html .= '<th>' . htmlspecialchars(ucfirst(str_replace('_', ' ', $header)), ENT_QUOTES, 'UTF-8') . '</th>';
                }
            }
            $html .= '</tr></thead>';

            // Membuat baris data
            $html .= '<tbody>';
            $no = 1;
            foreach ($data as $row) {
                $html .= '<tr><td>' . htmlspecialchars($no++, ENT_QUOTES, 'UTF-8') . '</td>';
                foreach ($row as $key => $value) {
                    if ($key !== 'id') { // Menghilangkan kolom 'id'
                        $value = ($value === null || $value === '') ? '-' : $value; // Mengganti nilai kosong/null dengan '-'
                        $html .= '<td>' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</td>';
                    }
                }
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }

        $html .= '</table>';

        if ($tableName == 'barang-keluar' || $tableName == 'pengembalian-barang') {
            if ($tableName == 'barang-keluar') {
                $html .= '
            <div style="margin-top: 20px; text-align: justify; font-size: 10pt;">
                <p>Apabila terjadi kerusakan atau kehilangan, maka saya bertanggung jawab untuk memperbaiki/mengganti sesuai dengan kondisi barang saat diterima/dipinjam.</p>
            </div>
            ';
            } else {
                $html .= '
            <div style="margin-top: 20px; text-align: justify; font-size: 10pt;">
                <p>Dokumen asli disimpan di Penanggung Jawab dan Salinan disimpan oleh peminjam serta petugas BMN selama alat/barang/bahan dipinjam.</p>
            </div>
            ';
            }

            $html .= '
            <div style="margin-top: 50px; width: 100%; text-align: center;">
                <table style="width: 100%; border-collapse: collapse; border: none;">
                    <tr>
                        <td style="width: 33%; text-align: left; vertical-align: middle; border: none;">
                            <p>Bekasi, ' . date('d F Y', strtotime($printDate)) . '</p>
                        </td>
                    </tr>
                    <tr>
                        <!-- Kolom Peminjam -->
                        <td style="width: 33%; text-align: center; vertical-align: top; border: none;">
                            <p>Peminjam</p>
                            <br><br><br><br>
                            <p style="line-height: 1; margin-bottom: 0;">( ' . htmlspecialchars($namaUser, ENT_QUOTES, 'UTF-8') . ' )</p>
                        </td>
                        <!-- Kolom Diserahkan Oleh -->
                        <td style="width: 33%; text-align: center; vertical-align: top; border: none;">
                            <p>Diserahkan Oleh</p>
                            <br><br><br><br>
                            <p style="line-height: 1; margin-bottom: 0;">( Qodri Adriyanto )</p>
                        </td>
                        <!-- Kolom Mengetahui -->
                        <td style="width: 33%; text-align: center; vertical-align: top; border: none;">
                            <p>Menyetujui</p>
                            <br><br><br><br>
                            <p style="line-height: 1; margin-bottom: 0;">( Hasfarm Dian Purba, S.T., M.T. )</p>
                        </td>
                    </tr>
                </table>
            </div>';
        }

        // Menambah CSS dan HTML ke PDF
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // Menyimpan file PDF ke browser untuk diunduh
        return $mpdf->Output($filename, 'D');
    }

    // Fungsi untuk generate file Excel
    private function generateExcel($data, $filename)
    {
        // Pastikan data tidak kosong
        if (empty($data)) {
            throw new \Exception("Data kosong. Tidak ada data untuk diekspor.");
        }

        // Membuat instance Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis header tabel di baris pertama
        $column = 'A';
        foreach (array_keys($data[0]) as $header) {
            if ($header !== 'id') { // Menghilangkan kolom 'id'
                $sheet->setCellValue($column . '1', ucfirst(str_replace('_', ' ', $header)));
                $column++;
            }
        }

        // Menulis baris data
        $rowNum = 2;
        foreach ($data as $row) {
            $column = 'A';
            foreach ($row as $key => $value) {
                if ($key !== 'id') { // Menghilangkan kolom 'id'
                    $sheet->setCellValue($column . $rowNum, $value);
                    $column++;
                }
            }
            $rowNum++;
        }

        // Menulis file ke php://output
        try {
            $writer = new Xlsx($spreadsheet);

            // Atur header untuk unduhan file Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            // Output file langsung ke browser
            $writer->save('php://output');
            exit; // Hentikan eksekusi setelah file diunduh
        } catch (\Exception $e) {
            throw new \Exception("Error saat membuat file Excel: " . $e->getMessage());
        }
    }
}
