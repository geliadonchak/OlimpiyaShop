<?php


namespace App\Managers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductManager implements ManagerInterface
{
    /**
     * @param int $count
     * @return Collection[Product]
     */
    public function getTopProducts(int $count = 10) : Collection
    {
        return Product::query()
            ->orderByDesc('rating')
            ->take($count)
            ->get();
    }

    /**
     * @return Collection[Product]
     */
    public function getAll()
    {
        return Product::all();
    }

    /**
     * @param int $productId
     * @return Product|null
     */
    public function getById(int $productId) : ?Product
    {
        return Product::query()
            ->where('id', $productId)
            ->take(1)
            ->get()[0] ?? null;
    }
}
