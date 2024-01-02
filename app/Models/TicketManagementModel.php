<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketManagementModel extends Model
{
    protected $table            = 'ticketmanagements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'quota_per_day',
        'status',
        'the_day',
    ];

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

    public function getPaginateSearch(string|null $keyword = null, $perPage, $page)
    {
        $builder = $this->builder($this->table);
        $builder->groupStart();
        $builder->whereNotIn('status', ['to_all_date']);
        $builder->groupEnd();

        if ($keyword) {
            $builder->like('quota_per_day', $keyword)
                ->orLike('status', $keyword)
                ->orLike('the_day', $keyword);
        }

        return [
            'listTicketManagements' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager
        ];
    }

    public function getDataByDate($date) 
    {
        
        $builder = $this->builder($this->table);
        $builder->where("DATE(the_day) = '{$date}'");
        $builder->select("id,quota_per_day");

        return $builder->get()->getRowArray();
    }

    public function getMainQuotaToAllDate() 
    {
        $builder = $this->builder($this->table);
        $builder->where('status', 'to_all_date');
        return $builder->get()->getRowArray();
    }

}
