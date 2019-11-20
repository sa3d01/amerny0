<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\Types\Object_;

class User extends Authenticatable
{
    use Notifiable;
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','type','mobile', 'email','image','apiToken','device_token','device_type','activation_code','status','notify', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'device_token' => 'json',
    ];


    public function setImageAttribute()
    {
        if(request()->hasFile('image')){
            $file = request()->file('image');
            $destinationPath = 'images/user/';
            $filename = str_random(10).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $this->attributes['image'] = $filename;
        }
    }

    public function getImageAttribute()
    {
        if ($this->attributes['image']) {
            return asset('images/user/') . '/' . $this->attributes['image'];
        }
        return asset('images/user/admin.png');
    }

    public function setPasswordAttribute($password)
    {
        if (isset($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    protected $index_fields  = ['id','name','type','mobile', 'email','image','activation_code','status','apiToken'];

    public function static_model()
    {
        $arr=[];
        foreach ($this->index_fields as $index_field){
            $this->$index_field ? $arr[$index_field] = $this->$index_field : null;
        }
        return $arr;
    }

}
