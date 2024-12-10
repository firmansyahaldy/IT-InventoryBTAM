<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $DBGroup = 'default';

    public function getTableData($table)
    {
        return $this->db->table($table)->get()->getResultArray();
    }

    public function getUserData()
    {
        return $this->db->table('user')
            ->select('user.id_user as id, user.username as username, user.nama_user as nama user, role.user_role as user role, jabatan.nama_jabatan as jabatan')
            ->join('role', 'role.id_role = user.id_role', 'left')
            ->join('jabatan', 'jabatan.id_jabatan = user.id_jabatan', 'left')
            ->get()
            ->getResultArray();
    }

    public function getBarangData()
    {
        return $this->db->table('barang')
            ->select('barang.id_barang as id, 
                        barang.kode_barang as `kode barang`, 
                        kategori.kategori_item as `kategori`, 
                        barang.nama_barang as `nama barang`, 
                        barang.merk as `merk`, 
                        barang.spesifikasi as `spesifikasi`, 
                        barang.tipe as `tipe`, 
                        barang.tgl_pembelian as `tgl pembelian`, 
                        barang.harga_pembelian as `harga beli`, 
                        status_barang.status_barang as `status barang`, 
                        barang.kuantitas as `kuantitas`, 
                        kondisi.kondisi_item as `kondisi item`, 
                        barang.masa_garansi as masa `garansi`, 
                        barang.serial_number as serial `number`, 
                        lokasi_barang.lokasi_barang as `lokasi item`, 
                        barang.maintenance_selanjutnya as `pemeliharaan selanjutnya`')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left')
            ->join('status_barang', 'status_barang.id_status_barang = barang.id_status_barang', 'left')
            ->join('kondisi', 'kondisi.id_kondisi = barang.id_kondisi', 'left')
            ->join('lokasi_barang', 'lokasi_barang.id_lokasi_barang = barang.id_lokasi_barang', 'left')
            ->get()
            ->getResultArray();
    }

    public function getBarangDataWithConditions()
    {
        // Query untuk mengambil data kategori dan distribusi kondisi barang
        $barangData = $this->db->table('kategori')
        ->select('
                    kategori.kategori_item as kategori, 
                    COUNT(barang.id_barang) as jumlah,
                    SUM(CASE WHEN kondisi.kondisi_item = "Baik" THEN 1 ELSE 0 END) as baik,
                    SUM(CASE WHEN kondisi.kondisi_item = "Rusak" THEN 1 ELSE 0 END) as rusak,
                    SUM(CASE WHEN kondisi.kondisi_item = "Habis Masa Pakai" THEN 1 ELSE 0 END) as habis_masa_pakai')
        ->join('barang', 'kategori.id_kategori = barang.id_kategori', 'left')
        ->join('kondisi', 'kondisi.id_kondisi = barang.id_kondisi', 'left')
        ->groupBy('kategori.id_kategori, kategori.kategori_item')  // Mengelompokkan berdasarkan kategori
        ->get();

        if ($barangData === false) {
            throw new \RuntimeException('Query gagal dijalankan: ' . $this->db->getLastQuery());
        }

        return $barangData->getResultArray();
    }

    public function getMaintenanceData()
    {
        return $this->db->table('maintenance')
            ->select('maintenance.id_maintenance as `id`,
                        maintenance.id_barang as `id barang`,
                        barang.nama_barang as nama `barang`,
                        maintenance.deskripsi as `deskripsi`,
                        maintenance.maintenance_selanjutnya as `pemeliharaan selanjutnya`,
                        status_maintenance.status_maintenance as `status pemeliharaan`,
                        maintenance.updated_at as `selesai pemeliharaan`,
                        maintenance.maintened_by as `dikerjakan oleh`')
            ->join('barang', 'barang.id_barang = maintenance.id_barang', 'left')
            ->join('status_maintenance', 'status_maintenance.id_status_maintenance = maintenance.id_status_maintenance', 'left')
            ->get()
            ->getResultArray();
    }

    public function getBarangKeluarData()
    {
        return $this->db->table('barang_keluar')
            ->select('barang_keluar.id_barang_keluar as `id`,
                        barang_keluar.id_barang as `id barang`,
                        barang_keluar.nama_barang as `nama barang`,
                        barang_keluar.jumlah as `jumlah`,
                        barang_keluar.tanggal_keluar as `tanggal keluar`,
                        barang_keluar.nama_penanggung_jawab as `penanggung jawab`,
                        barang_keluar.alasan as `alasan`,
                        barang_keluar.status_pengembalian as `status pengembalian`,
                        barang_keluar.tanggal_kembali as `tgl kembali`')
            ->get()
            ->getResultArray();
    }

    public function returnBarang($startDate = null, $endDate = null)
    {
        // Jika tanggal tidak diset, ambil semua data return barang
        if (empty($startDate) || empty($endDate)) {
            return $this->db->table('barang_keluar')
            ->select('
                barang_keluar.id_barang_keluar as `id`,
                barang_keluar.id_barang as `id barang`,
                barang_keluar.nama_barang as `nama barang`,
                barang_keluar.jumlah as `jumlah`,
                kondisi.kondisi_item as `kondisi`,
                barang_keluar.tanggal_keluar as `tanggal keluar`,
                barang_keluar.tanggal_kembali as `tgl kembali`
            ')
            ->join('kondisi', 'kondisi.id_kondisi = barang_keluar.id_kondisi', 'left') // Join tabel kondisi
            ->get()
                ->getResultArray();
        }

        // Jika tanggal diset, ambil data sesuai rentang tanggal
        return $this->db->table('barang_keluar')
        ->select('
            barang_keluar.id_barang_keluar as `id`,
            barang_keluar.id_barang as `id barang`,
            barang_keluar.nama_barang as `nama barang`,
            barang_keluar.jumlah as `jumlah`,
            kondisi.kondisi_item as `kondisi`,
            barang_keluar.tanggal_keluar as `tanggal keluar`,
            barang_keluar.tanggal_kembali as `tgl kembali`
        ')
        ->join('kondisi', 'kondisi.id_kondisi = barang_keluar.id_kondisi', 'left') // Join tabel kondisi
        ->where('barang_keluar.tanggal_keluar >=', $startDate)
            ->where('barang_keluar.tanggal_keluar <=', $endDate)
            ->get()
            ->getResultArray();
    }

    public function getBarangKeluarDataByDate($startDate, $endDate)
    {
        // Jika tanggal tidak diset, ambil semua data barang keluar
        if (empty($startDate) || empty($endDate)) {
            return $this->db->table('barang_keluar')
                ->select('
                barang_keluar.id_barang_keluar as `id`,
                barang_keluar.nama_barang as `nama barang`,
                barang_keluar.jumlah as `jumlah`,
                kondisi.kondisi_item as `kondisi`,
                barang_keluar.lama_peminjaman as `lama peminjaman (hari)`,
                barang_keluar.estimasi_pengembalian as `estimasi pengembalian`,
            ')
                ->join('kondisi', 'kondisi.id_kondisi = barang_keluar.id_kondisi') // Join tabel kondisi
                ->get()
                ->getResultArray();
        }

        // Jika tanggal diset, ambil data sesuai rentang tanggal
        return $this->db->table('barang_keluar')
            ->select('
            barang_keluar.id_barang_keluar as `id`,
            barang_keluar.id_barang as `id barang`,
            barang_keluar.nama_barang as `nama barang`,
            barang_keluar.jumlah as `jumlah`,
            kondisi.kondisi_item as `kondisi`,
            barang_keluar.tanggal_keluar as `tanggal keluar`,
            barang_keluar.nama_penanggung_jawab as `penanggung jawab`,
            barang_keluar.alasan as `alasan`,
            barang_keluar.status_pengembalian as `status pengembalian`,
            barang_keluar.tanggal_kembali as `tgl kembali`
        ')
            ->join('kondisi', 'kondisi.id_kondisi = barang_keluar.id_kondisi') // Join tabel kondisi
            ->where('barang_keluar.tanggal_keluar >=', $startDate)
            ->where('barang_keluar.tanggal_keluar <=', $endDate)
            ->get()
            ->getResultArray();
    }

    protected $table            = 'laporans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
