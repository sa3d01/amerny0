<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends MasterModel
{
    protected $fillable = [
        'parent_id','name','status'
    ];
    protected $index_fields = [
        'id'
    ];
    protected $json_fields  = [
        'name'
    ];
    protected $casts = [
        'name' => 'json',
    ];
}
