<?php

namespace App\Http\Controllers;

use App\Category;
use App\Filters\UserFilter;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show product owners by given category slug and product slug
     *
     * @param Category $category
     * @param UserFilter $userFilter
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category, UserFilter $userFilter, $slug)
    {
        $products = $category->products()->whereSlug($slug)->get('user_id');

        $owners = User::with(['profile', 'ratings'])->filter($userFilter)->whereIn('id', $products)->get();

        return response()->json($owners, 200);
    }
}
