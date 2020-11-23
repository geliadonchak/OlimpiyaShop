<?php


namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends Controller
{

    /**
     * @return JsonResponse response
     */
    public function getCategories()
    {
        return new JsonResponse([
            'categories' => Category::all(),
        ]);
    }
}
