<?php


namespace App\Http\Controllers\Pages;

use App\Http\Controllers\BasePageController;
use Illuminate\Contracts\View\View;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends BasePageController
{
    /**
     * @param int $productId
     * @return View
     */
    public function product(int $productId)
    {
        $product = $this->productManager->getById($productId);
        if (empty($product)) {
            $this->pageNotFound();
        }

        $category = $this->categoryManager->getById($product->category_id);;
        $breadcrumbs[] = [$category->name, $category->id];
        while ($category->parent !== null) {
            $category = $category->parent;
            $breadcrumbs[] = [$category->name, $category->id];
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        $breadcrumbs[] = [$product->name, $product->id];

        return $this->viewResponse('pages.product', [
            'currentProduct' => $product,
            'currentProductCategory' => $category->name,
            'breadcrumb' => $breadcrumbs
        ]);
    }
}
