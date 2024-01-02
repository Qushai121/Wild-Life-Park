<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'image',
        'description',
        'access',
        'discount',
        'price',
        'qty',
        'publish',
        'totalqrcode'
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

    public function getPaginate_Search(string|null $keyword = null, $perPage, $page)
    {
        $builder = $this->builder($this->table);


        if ($keyword) {
            $builder->like('name', $keyword)
                ->orLike('access', $keyword)
                ->orLike('description', $keyword)
                ->orLike('publish', $keyword);
        }

        return [
            'listTickets' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager
        ];
    }

    public function getTicketByManyIds(array $ids, string $select)
    {
        $builder = $this->builder($this->table);
        $builder->whereIn('id', $ids)->select($select);

        // Execute the query and return the result
        return $builder->get()->getResultArray();
    }
}
