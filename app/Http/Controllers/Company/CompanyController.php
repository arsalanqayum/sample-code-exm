<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display all companies that own by authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $company = Company::where('user_id', auth()->id())->firstOrFail();

        return response()->json($company);
    }

    /**
     * Display companies own by authenticated user by given slug
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $company = Company::whereSlug($slug);

        if(auth()->user()) {
            if(auth()->user()->type == 'admin') {
                $company = $company->firstOrFail();
            } else {
                $company = $company->where('user_id', auth()->id())->firstOrFail();
            }
        } else {
            $company = $company->firstOrFail();
        }

        return response()->json($company);
    }
}
