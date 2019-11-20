<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends MasterModel
{
    public function __construct(Social $model)
    {
        $this->model = $model;
        $this->route = 'social';
        parent::__construct();
    }
    protected $fillable = [
        'image','name','link', 'status',
    ];
    protected $index_fields  = [
        'id','link','name','image', 'status'
    ];
}
