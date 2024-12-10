<?php

namespace App\Models;

use CodeIgniter\Model;

class MaintenanceModel extends Model
{
    protected $table            = 'maintenance';
    protected $primaryKey       = 'id_maintenance';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_barang',
        'nama_barang',
        'deskripsi',
        'maintenance_selanjutnya',
        'id_status_maintenance',
        'updated_at',
        'maintened_by'
    ];

    public function getMaintenanceWithStatus()
    {
        return $this->select('maintenance.*, status_maintenance.status_maintenance, barang.nama_barang')
            ->join('barang', 'maintenance.id_barang = barang.id_barang')
            ->join('status_maintenance', 'maintenance.id_status_maintenance = status_maintenance.id_status_maintenance')
            ->findAll();
    }
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = '';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_barang' => 'required|integer|is_not_unique[barang.id_barang]',
        'deskripsi' => 'required',
        'maintenance_selanjutnya' => 'required|valid_date',
        'id_status_maintenance' => 'required|integer|is_not_unique[status_maintenance.id_status_maintenance]',
        'updated_at' => 'permit_empty|valid_date',
        'maintened_by' => 'permit_empty|string|is_not_unique[user.username]',
    ];
    protected $validationMessages   = [
        'id_barang' => [
            'required' => 'Kode barang harus diisi',
            'is_not_unique' => 'Kode barang tidak valid',
        ],
        'nama_barang' => [
            'required' => 'Nama barang harus diisi',
        ],
        'deskripsi' => [
            'required' => 'Deskripsi maintenance harus diisi',
        ],
        'maintenance_selanjutnya' => [
            'required' => 'Tanggal maintenance harus diisi',
            'valid_date' => 'Tanggal maintenance harus berupa format yang valid',
        ],
        'id_status_maintenance' => [
            'required' => 'Status maintenance harus diisi',
            'is_not_unique' => 'Status maintenance tidak valid',
        ],
        'updated_at' => [
            'valid_date' => 'Tanggal maintenance harus berupa format yang valid',
        ],
        'maintened_by' => [
            'is_not_unique' => 'Username tidak valid',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['setUpdatedAt'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Fungsi untuk mengatur updated_at saat update
    protected function setUpdatedAt(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d');
        return $data;
    }
}
