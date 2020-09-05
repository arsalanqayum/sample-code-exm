<?php

namespace App\Http\Controllers\Admin;

use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    /**
     * Display all the listing article categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $acs = ArticleCategory::get();

        return response()->json($acs);
    }

    /**
     * Store newly created category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:article_categories',
            'parent_id' => 'nullable',
        ]);

        $ac = new ArticleCategory($data);

        $ac->slug = \Illuminate\Support\Str::slug($request->title);
        $ac->save();

        return response()->json($ac, 201);
    }
}
