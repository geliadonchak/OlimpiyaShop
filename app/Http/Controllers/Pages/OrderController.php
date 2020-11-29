<?php


namespace App\Http\Controllers\Pages;

use App\Http\Controllers\BasePageController;
use App\Managers\BasketManager;
use App\Managers\CategoryManager;
use App\Managers\OrderManager;
use App\Managers\ProductManager;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class OrderController extends BasePageController
{
    /**
     * @var OrderManager $orderManager
     */
    private $orderManager;

    /**
     * OrderController constructor.
     * @param CategoryManager $categoryManager
     * @param ProductManager $productManager
     * @param BasketManager $basketManager
     * @param OrderManager $orderManager
     */
    public function __construct(
        CategoryManager $categoryManager,
        ProductManager $productManager,
        BasketManager $basketManager,
        OrderManager $orderManager
    )
    {
        parent::__construct($categoryManager, $productManager, $basketManager);
        $this->orderManager = $orderManager;
    }


    public function addBasketToOrder()
    {
        $this->checkAuth();

        $userId = Auth::id();

        if (!$this->basketManager->getBasketCount($userId)) {
            return redirect()->back();
        }

        $basketItems = $this->basketManager->getById($userId);
        $this->orderManager->createOrder($basketItems->toArray());

        return Redirect::route('orders');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteOrder(Request $request)
    {
        $this->checkAuth();

        $orderId = $request->input('orderId');
        if ($orderId === null) {
            abort(400);
        }

        $this->orderManager->deleteOrder($orderId);

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function payOrder(Request $request)
    {
        $this->checkAuth();

        $orderId = $request->input('orderId');

        $this->orderManager->payOrder($orderId);

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function clearOrderHistory()
    {
        $this->checkAuth();

        $this->orderManager->deleteALlOrders(Auth::id());

        return redirect()->back();
    }

    /**
     * @return View
     */
    public function getAllOrders(): View
    {
        $this->checkAuth();

        $userId = Auth::id();

        $orders = $this->orderManager->getByUserId($userId);
        $breadcrumbs[] = ['Заказы', 'orders'];

        return $this->viewResponse('pages.orders', [
            'orders' => $orders,
            'breadcrumb' => $breadcrumbs
        ]);
    }
}
