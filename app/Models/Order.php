<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Order::first() == null) {
                $model->order_code = getSetting('order_code_start') != null ? (int) getSetting('order_code_start') : 1;
            } else {
                $model->order_code = (int) Order::max('order_code') + 1;
            }
        });
    }

    public function scopeIsPlaced($query)
    {
        return $query->where('order_status',3);
    }


    public function scopeIsPaid($query)
    {
        return $query->where('payment_status', paidPaymentStatus());
    }

    public function scopeIsUnpaid($query)
    {
        return $query->where('payment_status',1);
    }

    public function scopeIsPending($query)
    {
        return $query->where('order_status', 5);
    }

    public function scopeIsPlacedOrPending($query)
    {
        return $query->where('order_status',3)->orWhere('order_status', 5);
    }

    public function scopeIsProcessing($query)
    {
        return $query->where('order_status', 3);
    }

    public function scopeIsCancelled($query)
    {
        return $query->where('order_status', 2);
    }
    
    public function scopeIsDelivered($query)
    {
        return $query->where('order_status', 1);
    }

    # for single vendor hasOne todo::[update version] handle for multiple orders
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'order_id','order_id');
    }

    
    public function billingAddress()
    {
        return $this->belongsTo(UserAddress::class, 'address_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderUpdates()
    {
        return $this->hasMany(OrderUpdate::class,'order_id','order_id')->latest();
    }
}
