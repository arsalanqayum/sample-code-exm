<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\RegisterRequest;
use App\Services\Company\RegisterService;
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

    /**
     * Constructor
     *
     * @param RegisterService $registerService
     * @param VerificationService $verificationService
     * @return void
     */
    public function __construct(RegisterService $registerService, VerificationService $verificationService)
    {
        $this->registerService = $registerService;
        $this->verificationService = $verificationService;
    }

    /**
     * Store company user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = new User();
        $user->fill(Arr::only($data,[
            'first_name', 'last_name', 'email', 'password','phone'
        ]));

        DB::transaction(function() use($user, $request, $data){
            $user->password = Hash::make($request->password);
            $user->type = User::COMPANY;
            $user->save();

            $this->verificationService->sendVerification($user);

            $company = new Company();
            $company->fill(Arr::except($data,[
                'first_name', 'last_name', 'email', 'password','phone',
            ]));
            $company->user_id = $user->id;
            $company->slug = $this->registerService->unique_slug($request->name);

            $company->save();

            $company->contact_lists()->create(['name' => 'Uncategorized']);

            return response()->json('success');
        });
    }

    /**
     * Verify user phone number
     *
     * @param string $sms_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $verification = Verification::whereCode($request->sms_code)->first();

        if(!$verification) {
            return response()->json([
                'flash' => 'Wrong verification code'
            ], 422);
        }

        $verification->updateVerification();

        $user = User::findOrFail($verification->verificable_id);
        $user->status = User::ACTIVATED;
        $user->save();

        $token = $user->createToken('API')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
