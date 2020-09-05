<?php

namespace App\Services;

use App\Category;
use App\CategoryAttribute;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Add category attributes
     *
     * @param Category $category
     * @param mixed $request
     * @return void
     */
    public function addCategoryAttributes(Category $category, $request)
    {
        $fields = $request->fields;

        if(count($fields)) {
            foreach ($fields as $field) {
                $categoryAttribute = new CategoryAttribute();
                $categoryAttribute->category_id = $category->id;
                $categoryAttribute->fill($field);
                $categoryAttribute->key = Str::lower($field['key']);
                $categoryAttribute->save();
            }
        }
    }
}