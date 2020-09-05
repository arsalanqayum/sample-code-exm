<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryAttributeController extends Controller
{
    /**
     * Show category attribute by given category
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        $categoryAttrs = $category->attrs;

        return response()->json($categoryAttrs);
    }
}
