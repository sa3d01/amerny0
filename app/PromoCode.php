<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends MasterModel
{
    protected $fillable = [
        'start_date','end_date','percent','code', 'count',
    ];
    protected $index_fields = [
        'id','start_date','end_date','percent','code', 'count',
    ];
}
