<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $table            = 'barang_keluar';
    protected $primaryKey       = 'id_barang_keluar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_barang',
        'nama_barang',
        'jumlah',
        'tanggal_keluar',
        'nama_penanggung_jawab',
        'alasan',
        'status_pengembalian',
        'tanggal_kembali',
    ];

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

    public function getBarangKeluar()
    {
        return $this->select('barang_keluar.*, barang.kode_barang as kode barang, barang.nama_barang AS barang_nama')
            ->join('barang', 'barang.id_barang = barang_keluar.id_barang')
            ->findAll();
    }

    public function getBarangKeluarById($id_barang_keluar)
    {
        return $this->where('id_barang_keluar', $id_barang_keluar)
            ->first();
    }

    // Validation
    protected $validationRules      = [
        'id_barang' => [
            'rules' => 'required|integer|is_not_unique[barang.id_barang]',
            'errors' => [
                'required' => 'Barang harus dipilih.',
                'integer' => 'ID barang harus berupa angka.',
                'is_not_unique' => 'Barang yang dipilih tidak ditemukan di database.'
            ]
        ],
        'nama_barang' => [
            'rules' => 'required|string|min_length[3]',
            'errors' => [
                'required' => 'Nama barang harus diisi.',
                'string' => 'Nama barang harus berupa teks.',
                'min_length' => 'Nama barang minimal harus terdiri dari 3 karakter.'
            ]
        ],
        'jumlah' => [
            'rules' => 'required|integer|greater_than[0]',
            'errors' => [
                'required' => 'Jumlah barang harus diisi.',
                'integer' => 'Jumlah barang harus berupa angka.',
                'greater_than' => 'Jumlah barang harus lebih dari 0.'
            ]
        ],
        'tanggal_keluar' => [
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required' => 'Tanggal keluar harus diisi.',
                'valid_date' => 'Format tanggal keluar tidak valid.'
            ]
        ],
        'nama_penanggung_jawab' => [
            'rules' => 'required|string|max_length[50]',
            'errors' => [
                'required' => 'Nama penanggung jawab harus diisi.',
                'string' => 'Nama penanggung jawab harus berupa teks.',
                'max_length' => 'Nama penanggung jawab tidak boleh lebih dari 50 karakter.'
            ]
        ],
        'alasan' => [
            'rules' => 'required|string|max_length[255]',
            'errors' => [
                'required' => 'Alasan barang keluar harus diisi.',
                'string' => 'Alasan barang keluar harus berupa teks.',
                'max_length' => 'Alasan barang keluar tidak boleh lebih dari 255 karakter.'
            ]
        ],
        'status_pengembalian' => [
            'rules' => 'permit_empty|in_list[Belum Dikembalikan, Sudah Dikembalikan]',
        ],
        'tanggal_kembali' => [
            'rules' => 'permit_empty|valid_date[Y-m-d]',
            'errors' => [
                'valid_date' => 'Format tanggal kembali tidak valid.'
            ]
        ],
    ];
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
