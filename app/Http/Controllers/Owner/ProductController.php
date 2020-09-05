<?php

namespace App\Http\Controllers\Owner;

use App\Category;
use App\Filters\ProductFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ProductRequest;
use App\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /** @var ProductService */
    public $productService;

    /**
     * Constructor
     *
     * @param ProductService $productService
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductFilter $productFilter
     * @return \Illuminate\Http\Response
     */
    public function index(ProductFilter $productFilter)
    {
        $products = Product::filter($productFilter)->where('user_id', auth()->id())->get();

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        if(Product::where('user_id', auth()->id())->where('status', 'pending')->count()) {
            return response()->json(['flash' => 'You cannot add product until the last product is verified'], 422);
        }

        $product = (new Product())->fill(Arr::only($data, Product::BASIC_COLUMN));

        $product->user_id = auth()->id();

        $attrs = $request->except(Product::BASIC_COLUMN);

        $product->name = implode(' ', $attrs);

        if($product->save()) {
            $this->productService->addProductAttributeValues($product, Arr::except($data, Product::BASIC_COLUMN));
        }

        return response()->json(['flash' => 'Product has been added, waiting to approved by admin']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
