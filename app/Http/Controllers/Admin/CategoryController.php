<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /** @var categoryService */
    public $categoryService;

    /**
     * Constructor
     *
     * @param CategoryService $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display all categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return response()->json($categories,200);
    }

    /**
     * Update category by given slug
     *
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $slug)
    {
        $category = Category::whereSlug($slug)->doesntHave('products')->firstOrFail();

        $category->status = $request->status;
        $category->save();

        return response()->json(['flash' => "Category update successfully"], 201);
    }

    /**
     * Store newly create category
     *
     * @param CategoryStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if($category->save()) {
            $this->categoryService->addCategoryAttributes($category, $request);
        }

        return response()->json(['flash' => 'Successfully add category'], 201);
    }

    /**
     * Destroy category by given slug
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($slug)
    {
        $category = Category::whereSlug($slug)->doesntHave('products')->firstOrFail();

        $category->delete();

        return response()->json(['flash' => 'Category has been deleted'], 201);
    }
}
