<?php

namespace App\Http\Controllers\Owner;

use App\CategoryAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryAttributeController extends Controller
{
    /**
     * Show category attributes by given category_id
     *
     * @param int $category_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($category_id)
    {
        $categoryAttributes = CategoryAttribute::where('category_id', $category_id)->get();

        return response()->json($categoryAttributes, 200);
    }
}
