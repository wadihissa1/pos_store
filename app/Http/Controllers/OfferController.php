<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->offersForStore()
            ->with(['category', 'defaultUnit', 'websiteSetting.websiteCategory'])
            ->orderedForStore()
            ->paginate(12);

        return view('pages.offers.index', [
            'products' => $products,
        ]);
    }
}
