<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];



    public function sumPriceOrder()
    {
        return $this->orderDetails->sum(function ($orderDetail) {
            return $orderDetail->price * $orderDetail->qty;
        });
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Get the waiter associated with the order.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /******  1c2466b6-5eda-4bf1-a0c3-f6782ecb05be  *******/
    public function waiters()
    {
        return $this->belongsTo(User::class, 'waiters_id', 'id');
    }


    /**
     * Get the cashier that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }
}
