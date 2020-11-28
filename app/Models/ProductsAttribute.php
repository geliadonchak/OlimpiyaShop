<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    protected $table = 'products_attributes';
    protected $primaryKey = 'id';

    public static function saveProductAttribute($name, $value, $product_id)
    {
        $product_attribute = new ProductsAttribute();
        $product_attribute->name = $name;
        $product_attribute->value = $value;
        $product_attribute->product_id = $product_id;
        $product_attribute->save();
        return $product_attribute->getKey();
    }
}
