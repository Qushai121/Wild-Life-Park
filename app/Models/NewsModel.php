<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'publish',
        'content',
        'background_image',
        'author_id',
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
    protected $validationRules      = [
        'title' => 'required|min_length[3]',
        'publish' => 'required',
        'content' => 'required|min_length[10]',
        'background_image' => "uploaded[background_image]"
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

    public function getPaginateSearchByAuthorId(string|null $keyword = null, $perPage, $page)
    {
        $builder = $this->builder($this->table);
        $builder->where('author_id', auth()->user()->id);
        $builder->join('users', "users.id = $this->table.author_id", 'LEFT');
        $builder->select("users.id,users.username");
        $builder->select("news.title,news.publish,news.background_image,news.created_at,news.updated_at");
        $builder->select("news.id as news_id");

        if ($keyword) {
            $builder->like("news.title", $keyword)
                ->orLike("news.publish", $keyword);
        }

        return [
            'listNewss' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager
        ];
    }
    public function getPaginateSearchAllPublished(string|null $keyword = null, $perPage, $page, $time)
    {
        $builder = $this->builder($this->table);
        $builder->groupStart();
        $builder->where('publish', 'publish');
        $builder->groupEnd();
        $builder->join('users', "users.id = $this->table.author_id", 'LEFT');
        $builder->select("users.id,users.username");
        $builder->select("news.title,news.background_image,news.created_at,news.updated_at");
        $builder->select("news.id as news_id");

        if ($time) {

            $builder->groupStart();
            $builder->where("DATE($this->table.created_at) = '{$time}'");
            $builder->groupEnd();
        }
        if ($keyword) {
            $builder->like("news.title", $keyword)
                ->orLike("news.publish", $keyword);
        }

        return [
            'listNewss' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager
        ];
    }

    public function getByIdJoinUsers($id)
    {
        $builder = $this->builder($this->table);
        $builder->groupStart();
        $builder->where("$this->table.id", $id);
        $builder->where('publish', 'publish');
        $builder->groupEnd();
        $builder->join('users', "users.id = $this->table.author_id", 'LEFT');
        $builder->select("users.id,users.username");
        $builder->select("news.title,news.background_image,news.created_at,news.updated_at,news.content");
        $builder->select("news.id as news_id");

        return $builder->get()->getFirstRow('array');
    }

    public function getForCardWhereNotId($id)
    {
        $builder = $this->builder($this->table);
        $builder->groupStart();
        $builder->whereNotIn("$this->table.id", $id);
        $builder->where('publish', 'publish');
        $builder->groupEnd();
        $builder->join('users', "users.id = $this->table.author_id", 'LEFT');
        $builder->select("users.id,users.username");
        $builder->select("news.title,news.background_image,news.created_at,news.updated_at,news.content");
        $builder->select("news.id as news_id");

        return $builder->get(10)->getResultArray();
    }
}
