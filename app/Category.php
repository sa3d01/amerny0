<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends MasterModel
{
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
