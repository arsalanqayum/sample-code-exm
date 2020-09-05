<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\OwnerChat;
use App\OwnerRating;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class StatController extends Controller
{
    /** @var ProductService */
    public $productService;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display stats for owner
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $totalProducts = $this->productService->getTotalOwnerProductServices();
        $totalChats = OwnerChat::whereHas('messages')->where('user_id', auth()->id())->count();
        $rating = OwnerRating::where('user_id', auth()->id());

        return response()->json([
            'totalProducts' => $totalProducts,
            'totalChats' => $totalChats,
            'totalRatings' => $rating->count(),
            'averageRatings' => $rating->avg('rating'),
        ],200);
    }
}
