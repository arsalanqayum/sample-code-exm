<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Get list of tags
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tags = Tag::where('taggable_id', company()->id)->ofName(request('name'))->get();

        return response()->json($tags);
    }
}
