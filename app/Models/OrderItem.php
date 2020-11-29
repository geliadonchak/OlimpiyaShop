<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
