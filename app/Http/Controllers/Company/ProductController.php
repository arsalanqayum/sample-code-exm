<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display owner products that related to the company
     *
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($user_id)
    {
        $products = Product::where([
            'user_id' => $user_id,
            'bought_at' => company()->id,
        ])->paginate(12);

        return response()->json(['products' => $products]);
    }

    /**
     * Update owner product status
     *
     * @param int $user_id
     * @param int $product_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($user_id, $product_id, Request $request)
    {
        $data = $request->validate([
            'status' => 'required'
        ]);

        $product = Product::where([
            'user_id' => $user_id,
            'bought_at' => company()->id,
            'status' => Product::BEING_VERIFIED,
        ])->firstOrFail();

        $product->status = $data['status'];
        $product->save();

        return response()->json(['flash' => 'Product has been verified']);
    }
}
