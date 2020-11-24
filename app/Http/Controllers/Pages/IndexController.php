<?php


namespace App\Http\Controllers\Pages;

use App\Http\Controllers\BasePageController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends BasePageController
{
    /**
     * @return View
     */
    public function index()
    {
        return $this->viewResponse('pages.index', [
            'products' => $this->productManager->getTopProducts()
        ]);
    }

    public function logout()
    {
        $this->middleware('auth');

        Auth::logout();

        return redirect()->back();
    }
}
