<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Search product
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request, ProductFilter $productFilter)
    {
        $products = Product::with('category')->filter($productFilter)->groupBy(['name', 'category_id'])->get();

        return response()->json($products);
    }
}
