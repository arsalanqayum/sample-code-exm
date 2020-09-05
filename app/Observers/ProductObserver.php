<?php

namespace App\Observers;

use App\Company;
use App\CompanyUser;
use App\Facades\Twilio;
use App\Notifications\NotifyProductToAdmin;
use App\Product;
use App\User;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Handle the product "saving" event
     *
     * @param Product $product
     * @return void
     */
    public function saving(Product $product)
    {
        $product->slug = Str::slug($product->name);
    }

    /**
     * Handle the product "created" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $body = __('product.pic_verification', ['product_name' => $product->name]);

        $company = Company::find($product->bought_at);

        if($company) {
            CompanyUser::firstOrCreate([
                'user_id' => $product->user_id,
                'company_id' => $company->id,
            ]);
        }

        Twilio::sendSMS($product->user->phone, $body);

        $user = User::where('type', 'admin')->first();

        if($user) {
            $user->notify(new NotifyProductToAdmin($product));
        }
    }
}
