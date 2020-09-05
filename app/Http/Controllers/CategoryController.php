<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    /**
     * Display all listings categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::whereStatus('published')->get();

        return response()->json($categories,200);
    }

    /**
     * Show category by given slug
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }
}
