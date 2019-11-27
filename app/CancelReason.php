<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelReason extends MasterModel
{

    protected $fillable = [
        'name', 'status',
    ];
    protected $casts = [
        'name' => 'json',
    ];
    protected $index_fields  = [
        'id'
    ];
    protected $json_fields  = [
        'name'
    ];
}
