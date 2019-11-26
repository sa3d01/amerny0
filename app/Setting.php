<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    protected $fillable = [
        'email','mobile','about'
    ];
    protected $casts = [
        'about' => 'json',
    ];
}
