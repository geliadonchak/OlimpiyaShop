<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public static function filter(Request $request)
    {
        $products = Product::query()->where('category_id', $request->get('category'));

        if ($request->get('price_min')) {
            $products->where('price', '>=', $request->get('price_min'));
        }

        if ($request->get('price_max')) {
            $products->where('price', '<=', $request->get('price_max'));
        }

        return $products->join('categories', 'category_id', '=', 'categories.id')->get(['categories.name as category_name', 'products.*']);
    }

    public static function saveProduct($name, $description, $price, $image, $category_id)
    {
        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->image = $image;
        $product->category_id = $category_id;
        $product->save();
        return $product->getKey();
    }
}
