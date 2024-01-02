<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkerModel extends Model
{
    protected $table            = 'workers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nik',
        'shift',
        'user_id',
        'qr_code'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nik' => 'required|min_length[16]|max_length[16]|integer',
        'shift' => 'required|min_length[1]',
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

  

    protected $joinUser;

    public function getUser(string|null $keyword = null,$perPage,$page)
    {
        $builder = $this->builder($this->table)
        ->join('users', "users.id = $this->table.user_id", 'LEFT');
        
        if ($keyword) {
            $builder->like("$this->table.nik", $keyword)
                ->orLike("$this->table.shift", $keyword)
                ->orLike('users.username', $keyword);
        }

        return [
            'listWorkers' => $this->paginate($perPage,'default',$page),
            'pager' => $this->pager
        ];
    }

    public function getWorkerInfoById($id)
    {
        $builder = $this->builder($this->table);
        $builder->join('users', "users.id = $this->table.user_id", 'LEFT');
        $builder->join('auth_group_user as agu',"agu.user_id = $this->table.id",'LEFT');

    }
}
