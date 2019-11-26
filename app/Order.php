<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends MasterModel
{
    protected $fillable = [
        'status','saved_place_id','user_id', 'services'
        ,'shift_id','day','promo_code_id','note','images'
        ,'provider_id','cancel_reason_id'
    ];
    protected $index_fields = [
        'id','status','saved_place_id','user_id', 'services'
        ,'shift_id','day','promo_code_id','note','images'
        ,'provider_id','cancel_reason_id'
    ];

    protected $casts = [
        'services' => 'array',
        'images' => 'array',
    ];
    public function saved_place()
    {
        return $this->belongsTo(SavedPlaces::class, 'saved_place_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
    public function promo_code()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }
    public function cancel_reason()
    {
        return $this->belongsTo(CancelReason::class, 'cancel_reason_id');
    }
}
