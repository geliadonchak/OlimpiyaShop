<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user', 'id');
    }

    public function orderItems()
    {
        return $this->belongsTo('App\Models\OrderItem', 'order_id', 'id');
    }
}
