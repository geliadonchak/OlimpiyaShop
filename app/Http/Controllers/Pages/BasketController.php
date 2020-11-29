<?php


namespace App\Http\Controllers\Pages;

use App\Http\Controllers\BasePageController;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends BasePageController
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addProductToBasket(Request $request): RedirectResponse
    {
        $this->checkAuth();

        $productId = $request->input('productId');
        $count = $request->input('count');

        if ($productId === null || $count === null) {
            abort(400);
        }

        $this->basketManager->addProductToBasket(Auth::id(), $productId, $count);

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function removeProductFromBasket(Request $request): RedirectResponse
    {
        $this->checkAuth();

        $productId = $request->input('productId');
        if ($productId === null) {
            abort(400);
        }

        $this->basketManager->removeProductFromBasket(Auth::id(), $productId);

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function removeAllProductsFromBasket() {
       $this->checkAuth();

       $this->basketManager->clearUserBasket(Auth::id());

       return redirect()->back();
    }

    /**
     * @return View
     * @throws Exception
     */
    public function basket(): View
    {
        $this->checkAuth();

        $userId = Auth::id();

        $basket = $this->basketManager->getById($userId)->toArray();
        $breadcrumbs[] = ['Корзина', 'basket'];

        $sum = 0;
        foreach ($basket as $item) {
            $sum += $item['count'] * $item['product']['price'];
        }

        return $this->viewResponse('pages.basket', [
            'basketItems' => $basket,
            'priceSum' => $sum,
            'deliveryPrice' => count($basket) * 100,
            'breadcrumb' => $breadcrumbs
        ]);
    }
}
