<?php


namespace App\Managers;


use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderManager implements ManagerInterface
{
    public function getAll()
    {
        return Order::query()->get();
    }


    public function getByUserId(int $userId, bool $active = true): array
    {
        return Order::query()
            ->where('user', $userId)
            ->where('is_deleted', !$active)
            ->with(['orderItems'])
            ->orderByDesc('created_at')
            ->get()
            ->toArray();
    }

    public function getById(int $orderId): ?Order
    {
        return Order::query()
            ->where('id', $orderId)
            ->take(1)
            ->get()[0] ?? null;
    }

    /**
     * @param array $basketItems
     * @return mixed
     */
    public function createOrder(array $basketItems)
    {
        $order = new Order();
        $order->is_deleted = false;
        $order->is_paid = false;
        $order->user = Auth::id();
        $order->price = 0;

        $basket = Basket::query()->where('user_id', Auth::id())->with(['product'])->get();
        foreach ($basket as $item) {
            $order->price += $item['product']['price'] * $item['count'] + 100;
            $item->delete();
        }

        $order->save();

        foreach ($basketItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item['product_id'];
            $orderItem->count = $item['count'];
            $orderItem->order_id = $order->id;
            $orderItem->save();
        }

        return $order->getKey();
    }

    /**
     * @param int $orderId
     * @throws Exception
     */
    public function deleteOrder(int $orderId)
    {
        $order = $this->getById($orderId);
        if ($order === null) {
            return;
        }

        $order->is_deleted = true;
        $order->save();
    }

    /**
     * @param int $userId
     * @throws Exception
     */
    public function deleteALlOrders(int $userId)
    {
        $orders = $this->getByUserId($userId);
        foreach ($orders as $order)  {
            $this->deleteOrder($order['id']);
        }
    }

    /**
     * @param int $orderId
     * @throws Exception
     */
    public function payOrder(int $orderId)
    {
        $order = $this->getById($orderId);
        if ($order === null) {
            return;
        }

        $order->is_paid = true;
        $order->save();
    }
}
