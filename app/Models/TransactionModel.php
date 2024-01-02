<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'status',
        'product_id',
        'order_id',
        'quantity',
        'snap_token',
        'price_then',
        'discount_then',
        'total_price_then',
        'product_category',
        'checkin_at',
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


    public function getTransactionByOrderId($order_id, $select, $product_category)
    {
        $builder = $this->builder($this->table);
        $builder->groupStart();
        $builder->where('product_category', $product_category);
        $builder->groupEnd();
        $builder->where('order_id', $order_id);
        $builder->select($select);

        return $builder->get()->getResultArray();
    }

    public function getTransactionByOrderIdWithTicket($order_id, $select)
    {
        $builder = $this->builder($this->table);
        $builder->groupStart();
        $builder->where('product_category', 'ticket');
        $builder->groupEnd();
        $builder->where('order_id', $order_id);
        $builder->join('tickets', "tickets.id = $this->table.product_id", 'LEFT');
        $builder->select($select);
        $builder->select('transactions.id as transaction_id');
        $builder->select('tickets.id as ticket_id');

        return $builder->get()->getResultArray();
    }
    
   

    public function getTransactionByUserIdWithTicket($user_id, $select)
    {

        $builder = $this->builder($this->table);
        $builder->groupBy('order_id');
        $builder->where('user_id', $user_id);
        $builder->join('tickets', "tickets.id = $this->table.product_id", 'LEFT');
        $builder->select($select);
        $builder->select('transactions.id as transaction_id');
        $builder->select('tickets.id as ticket_id');

        return $builder->get()->getResultArray();
    }


    

}
