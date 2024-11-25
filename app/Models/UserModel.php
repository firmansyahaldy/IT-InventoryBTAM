<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'password',
        'nama_user',
        'id_role',
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

    // Validation
    protected $validationRules      = [
        'username' => 'required|is_unique[user.username]|min_length[3]|max_length[50]', // pastikan username unique
        'password' => 'required|min_length[8]|max_length[255]',
        'nama_user' => 'required|max_length[50]',
        'id_role' => 'required|integer|is_not_unique[role.id_role]', // Pastikan id_role valid dan ada di tabel role
    ];
    protected $validationMessages   = [
        'username' => [
            'required' => 'Username harus diisi',
            'is_unique' => 'Username sudah terdaftar',
            'min_length' => 'Username minimal 3 karakter',
            'max_length' => 'Username maksimal 50 karakter',
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 8 karakter',
            'max_length' => 'Password maksimal 255 karakter',
        ],
        'nama_user' => [
            'required' => 'Nama pengguna harus diisi',
            'max_length' => 'Nama pengguna maksimal 50 karakter',
        ],
        'id_role' => [
            'required' => 'Role pengguna harus diisi',
            'is_not_unique' => 'Role tidak valid',
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

    public function getUserWithRole($username)
    {
        return $this->select('user.*, role.user_role')
            ->join('role', 'role.id_role = user.id_role')
            ->where('user.username', $username)
            ->first();
        // Kembalikan null jika user tidak ditemukan
        return $user ?: null;
    }

    public function getUsersExport()
    {
        return $this->select('user.username, user.nama_user, role.user_role')
            ->join('role', 'user.id_role = role.id_role')
            ->findAll();
    }

    public function getUsersWithRoles()
    {
        return $this->join('role', 'user.id_role = role.id_role')
            ->select('user.*, role.user_role')
            ->findAll();
    }
}
