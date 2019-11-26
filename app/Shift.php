<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends MasterModel
{
    protected $fillable = [
        'from_time','from_zone','to_time','to_zone', 'status',
    ];
    protected $index_fields = [
        'id','from_time','from_zone','to_time','to_zone'
    ];
}
