<?php

namespace App\Services;

use App\Buyer;
use App\Facades\Twilio;
use App\OwnerChat;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class BuyerService
{
    /**
     * Send sms to owners that buyer want to request a chat
     *
     * @param Request $request
     * @return void
     */
    public function notifyOwners(Request $request, Buyer $buyer)
    {
        $product = Product::whereSlug($request->product_slug)->first();

        if(count($request->owners) && $product) {
            $body = "{$buyer->first_name} want to chat with you, reply Yes/No to receive a text from a prospect who is considering product {$product->name}";

            $owners = User::whereIn('id', $request->owners)->get();
            foreach($owners as $owner) {
                $ownerChat = new OwnerChat();
                $ownerChat->user_id = $owner->id;
                $ownerChat->buyer_id = $buyer->id;
                $ownerChat->product_slug = $product->slug;
                $ownerChat->type = $request->type;

                if($ownerChat->save()) {
                    Twilio::sendSMS(
                        $owner->phone,
                        $body
                    );
                }
            }
        }
    }
}