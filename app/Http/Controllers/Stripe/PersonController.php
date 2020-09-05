<?php

namespace App\Http\Controllers\Stripe;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use App\Http\Requests\Stripe\StorePerson;
use App\StripeAccount;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Create Person
     *
     * @param StorePerson $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePerson $request)
    {
        $stripeAccount = StripeAccount::where('user_id', auth()->id())->firstOrFail();

        if($stripeAccount->person_id) {
            return response()->json(['flash' => 'Unable to create owner, owner already exist'], 422);
        }

        $data = $request->validated();

        $person = Stripe::createPerson($stripeAccount->account_id, $data);

        if($person) {
            return response()->json(['person' => $person, 'flash' => 'Owner added'], 201);
        }

        return response()->json(['flash' => 'Something went wrong'], 422);
    }
}
