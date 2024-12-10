<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id_barang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_barang',
        'id_kategori',
        'nama_barang',
        'merk',
        'spesifikasi',
        'tipe',
        'tgl_pembelian',
        'harga_pembelian',
        'id_status_barang',
        'kuantitas',
        'id_kondisi',
        'masa_garansi',
        'serial_number',
        'id_lokasi_barang',
        'maintenance_selanjutnya',
    ];

    public function getKondisiBarang()
    {
        return $this->db->table('barang')
            ->join('kondisi', 'barang.id_kondisi = kondisi.id_kondisi') // Gantilah dengan kolom yang sesuai untuk relasi
            ->select('kondisi.kondisi_item, COUNT(*) as total') // Mengambil kondisi_item dari tabel kondisi
            ->groupBy('kondisi.kondisi_item') // Group berdasarkan kondisi_item
            ->get()
            ->getResult();
    }

    // Fungsi join untuk mendapatkan semua data dari tabel barang beserta tabel-tabel yang berelasi
    public function getBarangWithDetails()
    {
        return $this->select('barang.*, kategori.kategori_item, kondisi.kondisi_item, status_barang.status_barang, lokasi_barang.lokasi_barang')
            ->join('kategori', 'barang.id_kategori = kategori.id_kategori')
            ->join('kondisi', 'barang.id_kondisi = kondisi.id_kondisi')
            ->join('status_barang', 'barang.id_status_barang = status_barang.id_status_barang')
            ->join('lokasi_barang', 'barang.id_lokasi_barang = lokasi_barang.id_lokasi_barang')
            ->findAll();
    }

    public function getBarang($id_barang)
    {
        return $this->select('barang.*, kategori.kategori_item, status_barang.status_barang, kondisi.kondisi_item, lokasi_barang.lokasi_barang')
            ->join('kategori', 'barang.id_kategori = kategori.id_kategori', 'left')
            ->join('status_barang', 'barang.id_status_barang = status_barang.id_status_barang', 'left')
            ->join('kondisi', 'barang.id_kondisi = kondisi.id_kondisi', 'left')
            ->join('lokasi_barang', 'barang.id_lokasi_barang = lokasi_barang.id_lokasi_barang', 'left')
            ->
        where('barang.id_barang', $id_barang)
            ->first();
    }

    public function getStackedBarChartData()
    {
        return $this->select('kategori_item AS kategori, kondisi_item AS kondisi, COUNT(*) AS jumlah')
        ->join('kategori', 'barang.id_kategori = kategori.id_kategori')
        ->join('kondisi', 'barang.id_kondisi = kondisi.id_kondisi')
        ->groupBy('kategori, kondisi')
        ->findAll();
    }

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
    protected $validationRules      = [
        'kode_barang' => 'required|max_length[64]|is_unique[barang.kode_barang]',
        'id_kategori' => 'required|integer|is_not_unique[kategori.id_kategori]',
        'nama_barang' => 'required|max_length[255]',
        'merk' => 'required|max_length[255]',
        'spesifikasi' => 'required',
        'tipe' => 'required|max_length[255]',
        'tgl_pembelian' => 'required|valid_date',
        'harga_pembelian' => 'required|integer',
        'id_status_barang' => 'required|integer|is_not_unique[status_barang.id_status_barang]',
        'kuantitas' => 'required|integer',
        'id_kondisi' => 'required|integer|is_not_unique[kondisi.id_kondisi]',
        'masa_garansi' => 'required|valid_date',
        'serial_number' => 'required|max_length[255]',
        'id_lokasi_barang' => 'required|integer|is_not_unique[lokasi_barang.id_lokasi_barang]',
        'maintenance_selanjutnya' => 'valid_date',
    ];
    protected $validationMessages   = [
        'nama_barang' => [
            'required' => 'Nama barang harus diisi',
            'max_length' => 'Nama barang maksimal 255 karakter',
        ],
        'merk' => [
            'required' => 'Merk harus diisi',
            'max_length' => 'Merk maksimal 255 karakter',
        ],
        'spesifikasi' => [
            'required' => 'Spesifikasi harus diisi',
        ],
        'tipe' => [
            'required' => 'Tipe harus diisi',
            'max_length' => 'Tipe maksimal 255 karakter',
        ],
        'tgl_pembelian' => [
            'required' => 'Tanggal perolehan harus diisi',
            'valid_date' => 'Tanggal perolehan harus format yang valid',
        ],
        'harga_pembelian' => [
            'required' => 'Nilai perolehan harus diisi',
            'integer' => 'Nilai perolehan harus berupa angka',
        ],
        'id_status_barang' => [
            'required' => 'Status item harus diisi',
            'integer' => 'Status item harus berupa angka',
        ],
        'kuantitas' => [
            'required' => 'Kuantitas harus diisi',
            'integer' => 'Kuantitas harus berupa angka',
        ],
        'masa_garansi' => [
            'required' => 'Masa garansi harus diisi',
            'valid_date' => 'Masa garansi harus berupa tanggal yang valid',
        ],
        'serial_number' => [
            'required' => 'Serial number harus diisi',
            'max_length' => 'Serial number maksimal 255 karakter',
        ],
        'maintenance_selanjutnya' => [
            'valid_date' => 'Maintenance selanjutnya harus berupa tanggal yang valid',
        ],
    ];
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
