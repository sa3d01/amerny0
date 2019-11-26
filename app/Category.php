<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends MasterModel
{
    protected $fillable = [
        'parent_id','name','image', 'status',
    ];

    protected $casts = [
        'name' => 'json',
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function subs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    protected $index_fields  = [
        'id','image'
    ];
    protected $json_fields  = [
        'name'
    ];
}
