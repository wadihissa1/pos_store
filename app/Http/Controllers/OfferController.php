<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->offers()
            ->with(['category', 'defaultUnit'])
            ->latest()
            ->paginate(12);

        return view('pages.offers.index', [
            'products' => $products,
        ]);
    }
}
