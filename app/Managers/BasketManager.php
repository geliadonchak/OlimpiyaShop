<?php

namespace App\Managers;

use App\Models\Basket;
use Exception;

class BasketManager implements ManagerInterface
{
    public function getAll()
    {
        return Basket::query()->get();
    }

    public function getById(int $userId)
    {
        return Basket::query()
            ->where('user_id', $userId)
            ->with(['product'])
            ->get();
    }

    public function getBasketByUserAndProduct(int $userId, int $productId): ?Basket
    {
        return Basket::query()
                ->where('product_id', $productId)
                ->where('user_id', $userId)
                ->take(1)
                ->get()[0] ?? null;
    }

    public function getBasketCount(int $userId): ?int
    {
        return Basket::query()
            ->where('user_id', $userId)
            ->count('*');
    }

    /**
     * @param int $userId
     * @param int $productId
     * @param int $count
     * @return int
     */
    public function addProductToBasket(int $userId, int $productId, int $count): int
    {
        /** @var Basket $basket */
        $basket = $this->getBasketByUserAndProduct($userId, $productId);

        if ($basket === null) {
            $basket = new Basket();
            $basket->user_id = $userId;
            $basket->product_id = $productId;
            $basket->count = $count;
            $basket->save();
            return $basket->getKey();
        }

        $basket->count += $count;
        $basket->save();
        return $basket->getKey();
    }

    /**
     * @param int $userId
     */
    public function clearBasket(int $userId): void
    {
        $baskets = $this->getById($userId);
        foreach ($baskets as $basket) {
            $basket->delete();
        }
    }

    /**
     * @param int $userId
     * @param int $productId
     * @throws Exception
     */
    public function removeProductFromBasket(int $userId, int $productId): void
    {
        $basket = $this->getBasketByUserAndProduct($userId, $productId);
        if ($basket !== null) {
            $basket->delete();
        }
    }

    /**
     * @param int $userId
     */
    public function removeProductFromUserBasket(int $userId): void
    {
        $basket = $this->getById($userId);
        if ($basket === null) {
            return;
        }

        foreach ($basket as $item) {
            $item->delete();
        }
    }
}
