<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleryModel extends Model
{
    protected $table            = 'galerys';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'images',
        'description',
        'type',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]',
        'description' => 'required|min_length[3]',
        'type' => 'required'
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



    public function getPaginate_Search(string|null $keyword = null, $perPage, $page)
    {
        $builder = $this->builder($this->table);

        if ($keyword) {
            $builder->like('title', $keyword)
                ->orLike('type', $keyword)
                ->orLike('description', $keyword);
        }

        return [
            'listGalerys' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager
        ];
    }

    public function getByTypePaginateSearch(string|null $keyword = null, $perPage, $page, $type)
    {
        $builder = $this->builder($this->table);
        $builder->groupStart();
        $builder->where('type', $type);
        $builder->groupEnd();

        if ($keyword) {
            $builder->like('title', $keyword)
                ->orLike('type', $keyword)
                ->orLike('description', $keyword);
        }

        return [
            'listGalerys' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager
        ];
    }
}
