<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'email','mobile','about'
    ];
    protected $casts = [
        'about' => 'json',
    ];
}
