<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \Mpdf\Mpdf;

use App\Controllers\BaseController;
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
        // Menyiapkan data tabel dan peran pengguna untuk view
        $data['tables'] = ['user', 'barang', 'maintenance', 'barang-keluar'];
        $data['userRole'] = $this->getUserRole();
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
        } elseif ($table == 'barang') {
            // Ambil data barang
            $data = $model->getBarangData();
        } elseif ($table == 'maintenance') {
            // Ambil data maintenance
            $data = $model->getMaintenanceData();
        }

        // Mengembalikan data dalam format JSON
        return $this->response->setJSON($data);
    }

    // Fungsi untuk ekspor data ke format yang diinginkan (PDF atau Excel)
    public function export($table, $format)
    {
        $model = new LaporanModel(); // Membuat instance dari model laporan
        $data = [];

        // Ambil data tambahan dari request GET (alamat tujuan dan penerima)
        $alamatTujuan = $this->request->getGet('alamatTujuan');
        $penerima = $this->request->getGet('penerima');

        // Ambil data berdasarkan tabel
        if ($table == 'user') {
            $data = $model->getUserData();
        } elseif ($table == 'maintenance') {
            $data = $model->getMaintenanceData();
        } elseif ($table == 'barang') {
            $data = $model->getBarangData();
            if ($format == 'pdf') {
                // Hapus kolom tertentu untuk format PDF
                foreach ($data as &$row) {
                    unset($row['kategori'], $row['harga beli'], $row['maintenance selanjutnya']);
                }
            }
        } elseif ($table == 'barang-keluar') {
            // Ambil filter tanggal dari request
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');
            $data = $model->getBarangKeluarDataByDate($startDate, $endDate);
            if ($format == 'pdf') {
                // Hapus kolom tertentu untuk format PDF
                foreach ($data as &$row) {
                    unset($row['id barang'], $row['status pengembalian'], $row['tgl kembali']);
                }
            }
        }

        // Tangkap tanggal pencetakan
        $printDate = date('Y-m-d');

        // Pilihan ekspor ke PDF atau Excel
        if ($format == 'pdf') {
            // Memanggil fungsi untuk generate PDF
            $this->generatePDF($data, $table . '_report_' . $printDate . '.pdf', $table, $printDate, $alamatTujuan, $penerima);
        } elseif ($format == 'excel') {
            // Memanggil fungsi untuk generate Excel
            $this->generateExcel($data, $table . '_report_' . $printDate . '.xlsx');
        }
    }

    // Fungsi untuk generate file PDF
    private function generatePDF($data, $filename, $tableName, $printDate, $alamatTujuan = '', $penerima = '')
    {
        // Meningkatkan batas waktu eksekusi dan memori
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        // Inisialisasi Mpdf dengan pengaturan margin
        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 60,
            'margin_right' => 10,
            'margin_bottom' => 20,
            'margin_left' => 10,
            'debug' => true
        ]);

        // Path ke file kop surat (sesuaikan path ini)
        $kopSuratPath = 'assets/img/kop surat-03.png';

        // Tambahkan kop surat dan tanggal pada header PDF
        $kopSurat = '
    <div style="text-align: center;">
        <img src="' . $kopSuratPath . '" width="100%" />
    </div>
    <div style="text-align: right;">
        <p>Bekasi, ' . htmlspecialchars($printDate, ENT_QUOTES, 'UTF-8') . '</p>
    </div>';
        $mpdf->SetHTMLHeader($kopSurat);

        // Definisi CSS untuk style di dalam PDF
        $css = '
        h1 { font-size: 16pt; text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { font-size: 10pt; padding: 5px; text-align: center; border: 1px solid black; }
        p { font-size: 12pt; margin: 10px 0; }
    ';

        // Mulai pembuatan HTML
        $html = '';

        // Jika tableName adalah 'barang-keluar', buat format surat jalan
        if ($tableName == 'barang-keluar') {
            $html .= '<h1>Surat Jalan</h1>';
            $html .= '<p>Kepada Yth:</p>';
            $html .= '<p>' . htmlspecialchars($penerima, ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>' . htmlspecialchars($alamatTujuan, ENT_QUOTES, 'UTF-8') . '</p>';
            $html .= '<p>Bersama dengan ini kami membawa sejumlah barang untuk dipergunakan sebagaimana mestinya:</p>';
        } else {
            // Judul laporan umum
            $html .= '<h1>Laporan ' . htmlspecialchars(ucfirst($tableName), ENT_QUOTES, 'UTF-8') . '</h1>';
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

        // Jika tableName adalah 'barang-keluar', tambahkan tanda tangan di bawah
        if ($tableName == 'barang-keluar') {
            $html .= '
    <div style="margin-top: 50px; width: 100%;">
        <div style="float: left; width: 50%; text-align: center;">
            <p>Mengetahui</p>
            <p>Penanggung Jawab,</p>
            <br><br><br>
            <p style="line-height: 1; margin-bottom: 0; margin-top: 40px;">' . htmlspecialchars($penerima, ENT_QUOTES, 'UTF-8') . '</p>
        </div>
        <div style="float: right; width: 50%; text-align: center;">
            <p>Pengirim,</p>
            <br><br><br>
            <p style="line-height: 1; margin-bottom: 0; margin-top: 40px;">' . htmlspecialchars('Nama Pengirim', ENT_QUOTES, 'UTF-8') . '</p>
        </div>
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
        // Membuat instance Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis header tabel di baris pertama
        if (!empty($data)) {
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
        }

        // Membuat writer untuk menulis ke file Excel
        $writer = new Xlsx($spreadsheet);

        // Mengirim file Excel ke browser untuk diunduh
        return $this->response->download($filename, $writer->save('php://output'));
    }
}
