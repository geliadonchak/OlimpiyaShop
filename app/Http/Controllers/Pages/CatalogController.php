<?php


namespace App\Http\Controllers\Pages;

use App\Http\Controllers\BasePageController;

/**
 * Class CatalogController
 * @package App\Http\Controllers
 */
class CatalogController extends BasePageController
{
    public function catalog(int $categoryId)
    {
        $category = $this->categoryManager->getById($categoryId);
        if (empty($category)) {
            $this->pageNotFound();
        }

        $cat = $category;
        $breadcrumbs[] = [$cat->name, $cat->id];
        while ($cat->parent !== null) {
            $cat = $cat->parent;
            $breadcrumbs[] = [$cat->name, $cat->id];
        }
        $breadcrumbs = array_reverse($breadcrumbs);

        return $this->viewResponse('pages.catalog', [
            'currentCategory' => $category,
            'breadcrumb' => $breadcrumbs
        ]);
    }
}
