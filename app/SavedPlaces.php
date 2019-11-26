<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedPlaces extends MasterModel
{
    protected $fillable = [
        'user_id','title','address'
    ];
    protected $index_fields  = [
        'id','title','address'
    ];
    protected $casts = [
        'address' => 'json',
    ];
}
