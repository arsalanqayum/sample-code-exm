<?php

namespace App\Http\Controllers\Admin;

use App\Filters\ProductFilter;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show all products
     *
     * @param ProductFilter $productFilter
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProductFilter $productFilter)
    {
        $products = Product::filter($productFilter)->paginate(15);

        return response()->json($products);
    }

    /**
     * Show product by given $id
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    /**
     * Update product
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'nullable',
        ]);

        $product = Product::findOrFail($id);

        $product->fill($data);
        $product->save();

        return response()->json($product, 201);
    }
}
