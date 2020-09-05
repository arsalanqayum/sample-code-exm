<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /** @var CompanyService */
    public $companyService;

    /**
     * Constructor
     *
     * @param CompanyService $companyService
     * @return void
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Login User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($data)) {
            $user = User::where(['email' => $data['email'], 'status' => 'active', 'is_verified' => true])->first();

            $token = $user->createToken('API')->accessToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 201);
        }

        return response()->json(['flash' => __('auth.failed')], 422);
    }

    /**
     * Logout authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if(Auth::user()->token()->revoke()){
           return response()->json('success', 201);
        }

        return response()->json(['flash' => 'Failed to logout'], 422);
    }

    /**
     * Get Current authenticated user via auth:api middleware
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return response()->json(auth()->user());
    }
}
