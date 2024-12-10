<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MaintenanceModel;
use App\Models\BarangModel;
use App\Models\StatusMaintenanceModel;
use CodeIgniter\I18n\Time;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MaintenanceController extends BaseController
{
    protected $maintenanceModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->maintenanceModel = new MaintenanceModel();
    }

    // Menampilkan halaman laporan maintenance
    public function index()
    {
        $session = \config\Services::session(); // Ambil instance session
        $userRole = $session->get('role'); // Ambil role dari session untuk menentukan hak akses
        $statusMaintenance = new \App\Models\StatusMaintenanceModel();
        $lokasiBarang = new \App\Models\LokasiBarangModel();

        $maintenanceModel = new MaintenanceModel();
        $data['maintenances'] = $maintenanceModel
            ->select('maintenance.*, status_maintenance.status_maintenance, lokasi_barang.lokasi_barang, barang.maintenance_selanjutnya')
            ->join('status_maintenance', 'status_maintenance.id_status_maintenance = maintenance.id_status_maintenance')
            ->join('barang', 'barang.id_barang = maintenance.id_barang')
            ->join('lokasi_barang', 'lokasi_barang.id_lokasi_barang = barang.id_lokasi_barang') // Join tabel lokasi_barang melalui tabel barang
            //->where('status_maintenance.id_status_maintenance !=', 3) // Jika diperlukan untuk filter maintenance yang belum selesai
            ->findAll();

        $data['userRole'] = $userRole; // Sertakan role user dalam data untuk view
        $data['statusMaintenances'] = $statusMaintenance->findAll();
        $data['lokasiBarangs'] = $lokasiBarang->findAll();

        return view('laporan', $data); // Kirim data ke view laporan
    }

    // Update data barang seperti maintenance selanjutnya dan kondisi barang
    public function updateBarang($id_barang, $maintenance_selanjutnya, $kondisi_barang)
    {
        $barangModel = new BarangModel();

        // Ambil data barang yang sudah ada
        $existingBarang = $barangModel->where('id_barang', $id_barang)->first();

        if ($existingBarang) {
            // Siapkan data yang akan diupdate
            $data = [
                'maintenance_selanjutnya' => $maintenance_selanjutnya,
                'id_kondisi' => $kondisi_barang,
            ];

            // Update barang
            if ($barangModel->update($id_barang, $data)) {
                log_message('info', 'Maintenance selanjutnya berhasil diupdate di tabel barang.');
                return true;
            } else {
                // Log error jika update gagal
                $errors = $barangModel->errors();
                log_message('error', 'Gagal mengupdate maintenance selanjutnya di tabel barang: ' . implode(', ', $errors));
                log_message('error', 'Error details: ' . print_r($barangModel->errors(), true));
                return false;
            }
        } else {
            log_message('error', 'Barang dengan ID ' . $id_barang . ' tidak ditemukan.');
            return false;
        }
    }

    // Mengupdate status maintenance dan barang terkait
    public function update()
    {
        $id_barang = $this->request->getPost('id_barang');
        $id_status_maintenance = $this->request->getPost('id_status_maintenance');
        $new_maintenance_selanjutnya = date('Y-m-d', strtotime('+1 year')); // Maintenance selanjutnya diatur 1 tahun setelah sekarang
        $kondisi_barang = 1; // Default kondisi barang menjadi 'Baik'
        // Ambil username pengguna yang login dari session
        $username = session()->get('username');

        log_message('info', 'ID Barang: ' . print_r($id_barang, true));

        if (!$id_barang) {
            return redirect()->back()->with('error', 'Kode Barang tidak ditemukan.');
        }

        // Ambil data barang dari database
        $barangModel = new BarangModel();
        $barangData = $barangModel->select('maintenance_selanjutnya')
        ->where('id_barang', $id_barang)
            ->first();

        // Jika data barang ditemukan, tambahkan 1 tahun pada field maintenance_selanjutnya
        if ($barangData && !empty($barangData['maintenance_selanjutnya'])) {
            $current_maintenance_selanjutnya = $barangData['maintenance_selanjutnya'];

            // Tambahkan 1 tahun ke tanggal maintenance selanjutnya
            $new_maintenance_selanjutnya = date('Y-m-d', strtotime($current_maintenance_selanjutnya . ' +1 year'));

            // Jika id_status_maintenance selesai, update data barang
            if ($id_status_maintenance == 3) {
                $updateBarang = $this->updateBarang($id_barang, $new_maintenance_selanjutnya, $kondisi_barang);
            } elseif ($id_status_maintenance == 5) {
                // Jika id_status_maintenance == 5, update kondisi_barang menjadi 3
                $kondisi_barang = 3;
                $updateBarang = $this->updateBarang($id_barang, $new_maintenance_selanjutnya, $kondisi_barang);
            } else {
                $updateBarang = true; // Jika status bukan 'selesai' atau '5', tidak perlu update barang
            }
        } else {
            log_message('error', 'Maintenance selanjutnya tidak ditemukan untuk ID barang: ' . $id_barang);
            return redirect()->back()->with('error', 'Data barang tidak ditemukan.');
        }

        // Update status di tabel maintenance
        $updateMaintenance = $this->updateMaintenance($id_barang, $id_status_maintenance, $username);

        // Jika update barang dan maintenance berhasil
        if ($updateBarang && $updateMaintenance) {
            return redirect()->to('/dashboard/laporan')->with('success', 'Barang dan Maintenance berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate Barang atau Maintenance.');
        }
    }

    // Mengupdate data di tabel maintenance berdasarkan kode barang
    public function updateMaintenance($id_barang, $id_status_maintenance, $username)
    {
        $maintenanceModel = new MaintenanceModel();

        $deskripsi = $this->request->getPost('deskripsi');

        // Data yang akan diupdate
        $data = [
            'id_status_maintenance' => $id_status_maintenance,
            'updated_at' => date('Y-m-d H:i:s'),
            'deskripsi' => $deskripsi
        ];

        // Jika status maintenance adalah 3 (selesai), tambahkan username ke field updated_by
        if ($id_status_maintenance == 3) {
            $data['maintened_by'] = $username; // Simpan username teknisi yang melakukan maintenance
        }

        // Update maintenance
        if ($maintenanceModel->where('id_barang', $id_barang)->set($data)->update()) {
            log_message('info', 'Status berhasil diupdate di tabel maintenance.');
            return true;
        } else {
            // Log error jika update gagal
            $errors = $maintenanceModel->errors();
            log_message('error', 'Gagal mengupdate status di tabel maintenance: ' . implode(', ', $errors));
            log_message('error', 'Error details: ' . print_r($maintenanceModel->errors(), true));
            return false;
        }
    }

    // Menghapus entri maintenance berdasarkan ID
    public function delete($id_maintenance)
    {
        $maintenanceModel = new MaintenanceModel();

        // Cek apakah data dengan ID tersebut ada
        $maintenanceData = $maintenanceModel->find($id_maintenance);
        if (!$maintenanceData) {
            return redirect()->back()->with('error', 'Data maintenance tidak ditemukan.');
        }

        // Lakukan penghapusan
        if ($maintenanceModel->delete($id_maintenance)) {
            return redirect()->to('/dashboard/laporan')->with('success', 'Maintenance berhasil dihapus.');
        } else {
            // Log error details
            log_message('error', 'Failed to delete maintenance with ID: ' . $id_maintenance);
            log_message('error', 'Error details: ' . print_r($maintenanceModel->errors(), true));

            return redirect()->back()->with('error', 'Gagal menghapus maintenance.');
        }
    }


    // Mengambil data maintenance berdasarkan ID untuk ditampilkan dalam JSON
    public function getMaintenance($id_maintenance)
    {
        $maintenanceModel = new MaintenanceModel();
        $maintenance = $maintenanceModel->find($id_maintenance);

        if ($maintenance) {
            return $this->response->setJSON($maintenance);
        } else {
            return $this->response->setStatusCode(404)->setBody('Maintenance tidak ditemukan');
        }
    }

    public function exportRepairPDF()
    {
        // Fetch data yang berhubungan dengan perbaikan
        $maintenance = $this->maintenanceModel->getMaintenanceWithStatus(); // Fetch data

        // Initialize TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Set title
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Laporan Perbaikan', 0, 1, 'C');
        $pdf->Ln(5);

        // Table content
        $pdf->SetFont('helvetica', '', 10);
        $html = '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Pemeliharaan selanjutnya</th>
                        <th>Status Pemeliharaan</th>
                        <th>Selesai Pemeliharaan</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($maintenance as $item) {
            // Only include records with status indicating repair is needed
            if ($item['status_maintenance'] == 'Membutuhkan Perbaikan') {
                $html .= '<tr>
                        <td>' . $item['id_barang'] . '</td>
                        <td>' . $item['nama_barang'] . '</td>
                        <td>' . $item['deskripsi'] . '</td>
                        <td>' . $item['maintenance_selanjutnya'] . '</td>
                        <td>' . $item['status_maintenance'] . '</td>
                        <td>' . $item['updated_at'] . '</td>
                        <td>' . $item['maintened_by'] . '</td>
                    </tr>';
            }
        }

        $html .= '</tbody></table>';

        // Write the content into the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output the PDF to the browser for download
        $this->response->setContentType('application/pdf');
        $pdf->Output('Laporan_Perbaikan.pdf', 'D');
    }
}
