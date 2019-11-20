<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterModel extends Model
{
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    protected $model;         // model name
    protected $route;         // route name
    protected $index_fields;    //model response for mobile

    public function setImageAttribute()
    {
        if(request()->hasFile('image')){
            $file = request()->file('image');
            $destinationPath = 'images/'.$this->route;
            $filename = str_random(10).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $this->attributes['image'] = $filename;
        }
    }

    public function getImageAttribute()
    {
        if ($this->attributes['image']) {
            return asset('images/') .$this->route. '/' . $this->attributes['image'];
        }
        return asset('images/user/admin.png');
    }

    public function static_model()
    {
        $arr=[];
        foreach ($this->index_fields as $index_field){
            $this->$index_field ? $arr[$index_field] = $this->$index_field : null;
        }
        return $arr;
    }
}
