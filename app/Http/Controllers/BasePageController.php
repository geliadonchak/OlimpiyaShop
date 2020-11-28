<?php


namespace App\Http\Controllers;

use App\Managers\BasketManager;
use App\Managers\CategoryManager;
use App\Managers\ProductManager;
use Illuminate\Support\Facades\Auth;

class BasePageController extends Controller
{
    /**
     * @var CategoryManager $categoryManager
     */
    protected $categoryManager;

    /**
     * @var ProductManager $productManager
     */
    protected $productManager;

    /**
     * @var BasketManager $basketManager
     */
    protected $basketManager;

    /**
     * BasePageController constructor.
     * @param CategoryManager $categoryManager
     * @param ProductManager $productManager
     * @param BasketManager $basketManager
     */
    public function __construct(CategoryManager $categoryManager, ProductManager $productManager, BasketManager $basketManager)
    {
        $this->categoryManager = $categoryManager;
        $this->productManager = $productManager;
        $this->basketManager = $basketManager;
    }

    public function viewResponse($view, $parameters)
    {
        return view($view, array_merge($parameters, [
            'basketCount' => Auth::check() ? $this->basketManager->getBasketCount(Auth::id()) : 0,
            'categories' => $this->categoryManager->getCategoriesWithParent(null)
        ]));
    }

    public function pageNotFound(): void
    {
        abort(404);
    }

    public function checkAuth(): void
    {
        if (!Auth::check()) {
            abort(403, 'Forbidden');
        }
    }
}
