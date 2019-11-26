<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends MasterModel
{
    protected $fillable = [
        'category_id','name','from','to', 'status',
    ];

    protected $casts = [
        'name' => 'json',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    protected $index_fields  = [
        'id','from','to'
    ];
    protected $json_fields  = [
        'name'
    ];
}
