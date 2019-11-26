<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends MasterModel
{
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    protected $fillable = [
        'image','name','link', 'status',
    ];
    protected $index_fields  = [
        'link','name'
    ];
}
