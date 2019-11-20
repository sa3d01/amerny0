<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedPlaces extends MasterModel
{
    public function __construct(SavedPlaces $model,$index_fields)
    {
        $this->model = $model;
        $this->route = 'saved_places';
        $this->index_fields=$index_fields;
        parent::__construct();
    }
    protected $fillable = [
        'user_id','title','address'
    ];
    protected $index_fields  = [
        'id','user_id','title','address'
    ];
    protected $casts = [
        'address' => 'json',
    ];
}
