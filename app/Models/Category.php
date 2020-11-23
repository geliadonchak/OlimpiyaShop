<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasRecursiveRelationships;

    protected $table = 'categories';
    protected $primaryKey = 'id';

    public static function saveCategory($name, $parentCategory)
    {
        $category = new Category();
        $category->name = $name;
        $category->parent_id = $parentCategory;
        $category->save();
        return $category->getKey();
    }

    public function products()
    {
        return $this->hasManyOfDescendantsAndSelf(Product::class, 'category_id', 'id');
    }
}
