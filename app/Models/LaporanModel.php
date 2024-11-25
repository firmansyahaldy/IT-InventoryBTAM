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
            ->select('user.id_user as id, user.username as username, user.nama_user as nama user, role.user_role as user role')
            ->join('role', 'role.id_role = user.id_role', 'left')
            ->get()
            ->getResultArray();
    }

    public function getBarangData()
    {
        return $this->db->table('barang')
            ->select('barang.id_barang as id, 
                        barang.kode_barang as kode barang, 
                        kategori.kategori_item as kategori, 
                        barang.nama_barang as nama barang, 
                        barang.merk as merk, 
                        barang.spesifikasi as spesifikasi, 
                        barang.tipe as tipe, 
                        barang.tgl_pembelian as tgl pembelian, 
                        barang.harga_pembelian as harga beli, 
                        status_barang.status_barang as status barang, 
                        barang.kuantitas as kuantitas, 
                        kondisi.kondisi_item as kondisi item, 
                        barang.masa_garansi as masa garansi, 
                        barang.serial_number as serial number, 
                        lokasi_barang.lokasi_barang as lokasi item, 
                        barang.maintenance_selanjutnya as maintenance selanjutnya')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left')
            ->join('status_barang', 'status_barang.id_status_barang = barang.id_status_barang', 'left')
            ->join('kondisi', 'kondisi.id_kondisi = barang.id_kondisi', 'left')
            ->join('lokasi_barang', 'lokasi_barang.id_lokasi_barang = barang.id_lokasi_barang', 'left')
            ->get()
            ->getResultArray();
    }

    public function getMaintenanceData()
    {
        return $this->db->table('maintenance')
            ->select('maintenance.id_maintenance as id,
                        maintenance.id_barang as id barang,
                        barang.nama_barang as nama barang,
                        maintenance.deskripsi as deskripsi,
                        maintenance.maintenance_selanjutnya as maintenance selanjutnya,
                        status_maintenance.status_maintenance as status maintenance,
                        maintenance.updated_at as updated at,
                        maintenance.maintened_by as maintened by')
            ->join('barang', 'barang.id_barang = maintenance.id_barang', 'left')
            ->join('status_maintenance', 'status_maintenance.id_status_maintenance = maintenance.id_status_maintenance', 'left')
            ->get()
            ->getResultArray();
    }

    public function getBarangKeluarData()
    {
        return $this->db->table('barang_keluar')
            ->select('barang_keluar.id_barang_keluar as id,
                        barang_keluar.id_barang as `id barang`,
                        barang_keluar.nama_barang as `nama barang`,
                        barang_keluar.jumlah as jumlah,
                        barang_keluar.tanggal_keluar as `tanggal keluar`,
                        barang_keluar.nama_penanggung_jawab as `penanggung jawab`,
                        barang_keluar.alasan as alasan,
                        barang_keluar.status_pengembalian as `status pengembalian`,
                        barang_keluar.tanggal_kembali as `tgl kembali`')
            ->get()
            ->getResultArray();
    }

    public function getBarangKeluarDataByDate($startDate, $endDate)
    {
        // Jika tanggal tidak diset, ambil semua data barang keluar
        if (empty($startDate) || empty($endDate)) {
            return $this->db->table('barang_keluar')
                ->select('barang_keluar.id_barang_keluar as id,
                        barang_keluar.id_barang as `id barang`,
                        barang_keluar.nama_barang as `nama barang`,
                        barang_keluar.jumlah as jumlah,
                        barang_keluar.tanggal_keluar as `tanggal keluar`,
                        barang_keluar.nama_penanggung_jawab as `penanggung jawab`,
                        barang_keluar.alasan as alasan,
                        barang_keluar.status_pengembalian as `status pengembalian`,
                        barang_keluar.tanggal_kembali as `tgl kembali`')
                ->get()
                ->getResultArray();
        }

        // Filter data berdasarkan rentang tanggal
        return $this->db->table('barang_keluar')
            ->select('barang_keluar.id_barang_keluar as id,
                    barang_keluar.id_barang as `id barang`,
                    barang_keluar.nama_barang as `nama barang`,
                    barang_keluar.jumlah as jumlah,
                    barang_keluar.tanggal_keluar as `tanggal keluar`,
                    barang_keluar.nama_penanggung_jawab as `penanggung jawab`,
                    barang_keluar.alasan as alasan,
                    barang_keluar.status_pengembalian as `status pengembalian`,
                    barang_keluar.tanggal_kembali as `tgl kembali`')
            ->where('tanggal_keluar >=', $startDate)
            ->where('tanggal_keluar <=', $endDate)
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
