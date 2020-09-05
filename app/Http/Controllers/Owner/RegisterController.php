<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerRegisterRequest;
use App\Services\CompanyService;
use App\Services\Owner\RegisterService;
use App\Services\VerificationService;
use App\User;
use App\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /** @var RegisterService */
    public $registerService;

    /** @var VerificationService */
    public $verificationService;

    /** @var CompanyService */
    public $companyService;

    /**
     * Constructor
     *
     * @param RegisterService $registerService
     * @param VerificationService $verificationService
     * @return void
     */
    public function __construct(RegisterService $registerService, VerificationService $verificationService, CompanyService $companyService)
    {
        $this->registerService = $registerService;
        $this->verificationService = $verificationService;
        $this->companyService = $companyService;
    }

    /**
     * Store owner registration
     *
     * @param OwnerRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OwnerRegisterRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $user = new User();
            $user->fill(
                Arr::only($data,$user->getFillable())
            );
            $user->type = 'owner';
            $user->password = Hash::make($request->password);
            $user->save();

            if($request->companySlug) {
                $this->companyService->registerToCompany($user, $request->companySlug);
            }

            $this->registerService->saveUserProfile($request, $user);

            $this->verificationService->sendVerification($user);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['flash' => 'Something went wrong'], 400);
        }

        DB::commit();

        return response()->json($user, 201);
    }

    /**
     * Verify user verification code
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $verification = Verification::whereCode($request->code)->where('verificable_id', $request->user_id)->first();

        if($verification) {
            $verification->updateVerification();

            $verification->verificable->verify(true);

            $user = User::findOrFail($request->user_id);

            $token = $user->createToken('API')->accessToken;

            return response()->json([
                'flash' => 'Registration success, you can continue to add product',
                'user' => $user,
                'token' => $token,
            ], 201);
        }

        return response()->json(['flash' => 'Verification code not found'], 422);
    }
}
