<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Filters\ArticleFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Get the listing of all articles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ArticleFilter $articleFilter)
    {
        $articles = Article::filter($articleFilter)->get();

        return response()->json($articles);
    }

    /**
     * Store newly created article
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'article_category_id' => 'required',
            'body' => 'required',
        ]);

        $article = new Article($data);
        $article->slug = \Illuminate\Support\Str::slug($request->title);

        $article->save();

        return response()->json($article, 201);
    }
}
