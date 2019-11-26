<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends MasterModel
{
    protected $fillable = [
        'image','name','link', 'status',
    ];
    protected $index_fields  = [
        'link','name'
    ];
}
