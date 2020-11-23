<?php


namespace App\Http\Controllers;

use App\Managers\CategoryManager;
use App\Managers\ProductManager;

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

    public function __construct(CategoryManager $categoryManager, ProductManager $productManager)
    {
        $this->categoryManager = $categoryManager;
        $this->productManager = $productManager;
    }

    public function viewResponse($view, $parameters)
    {
        return view($view, array_merge($parameters, [
            'categories' => $this->categoryManager->getCategoriesWithParent(null)
        ]));
    }

    public function pageNotFound()
    {
        abort(404);
    }
}
