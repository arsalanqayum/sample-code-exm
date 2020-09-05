<?php

namespace App\Http\Controllers\Company;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class OwnerController extends Controller
{
    /**
     * Show information of company's owner
     *
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user_id)
    {
        $owner = company()->users()->whereUserId($user_id)->firstOrFail();

        $requirements = collect();

        // if($owner->stripeAccount) {
        //     Stripe::retrieve($owner->stripeAccount->account_id);

        //     if(count(Stripe::accountRequirements())) {
        //         $currently_due = Stripe::accountRequirements()->currently_due;

        //         foreach ($currently_due as $cd) {
        //             $requirements->push($cd);
        //         }
        //     }
        // } else {
        //     $requirements->push('payment_account_require');
        // }

        if(!$owner->user->products()->where('bought_at', company()->id)->exists()) {
            $requirements->push('no_products');
        }

        $products = Product::where([
            'user_id' => $user_id,
            'bought_at' => company()->id,
        ])->paginate(12);

        return response()->json([
            'owner' => $owner->user,
            'requirements' => $requirements,
            'products' => $products
        ]);
    }
}
