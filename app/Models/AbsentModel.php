<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsentModel extends Model
{
    protected $table            = 'absents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'employee_id',
        'status',
        'shift',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = true;
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


    public function getByTime($keyword = null, $perPage, $page, $byTime)
    {
        $builder = $this->builder($this->table)
            ->join('users', "users.id = $this->table.employee_id", 'LEFT')
            ->select("$this->table.*")
            ->select('users.username,users.avatar');

        if (!empty($byTime)) {
            $builder->groupStart(); // Start grouping for time condition
            $builder->where("DATE($this->table.created_at) = '{$byTime}'");
            $builder->groupEnd(); // End grouping for time condition
        }

        if (!empty($keyword)) {
            // Add OR conditions only if keyword is present
            $builder->groupStart(); // Start grouping for keyword conditions
            $builder->like("users.username", $keyword)
                ->orLike("$this->table.shift", $keyword)
                ->orLike("$this->table.status", $keyword);
            $builder->groupEnd(); // End grouping for keyword conditions
        }

        return [
            'listAbsents' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager
        ];
    }

    public function getByIdEmployee($id)
    {
        $builder = $this->builder($this->table)
            ->where('employee_id', $id)->select(['created_at', 'status', 'shift'])->get();

        return $builder->getResultArray();
    }
}
