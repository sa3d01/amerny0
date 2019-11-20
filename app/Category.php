<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends MasterModel
{
    public function __construct(Category $model,$index_fields)
    {
        $this->model = $model;
        $this->route = 'category';
        $this->index_fields=$index_fields;
        parent::__construct();
    }
    protected $fillable = [
        'parent_id','name','image', 'status',
    ];
    protected $index_fields  = [
        'id','parent_id','name','image', 'status'
    ];

    protected $casts = [
        'name' => 'json',
    ];
}
