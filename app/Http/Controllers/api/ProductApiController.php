<?php


namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse response
     */
    public function getProducts(Request $request)
    {
        return new JsonResponse([
            'products' => Product::filter($request),
        ]);
    }
}

//удаление фото после удаления продукта
