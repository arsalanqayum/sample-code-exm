<?php
namespace App\Services\Product;

use App\CategoryAttribute;
use App\Product;
use App\ProductAttributeValue;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductService
{
    /**
     * Get all owner product services
     *
     * @return int|float
     */
    public function getTotalOwnerProductServices()
    {
        $id = auth()->id();

        $products = Product::where('user_id', $id)->count();

        return $products;
    }

    /**
     * Get all owner products
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOwnerProducts()
    {
        $id = auth()->id();

        $basicColumn = ['bought_at', 'state', 'city', 'category_id', 'name'];

        $products = Product::where('user_id', $id)->get($basicColumn);

        return $products;
    }

    /**
     * Add product attribute values to by given product id
     *
     * @param Product $product
     * @param array $data
     * @return void
     */
    public function addProductAttributeValues(Product $product, $data)
    {
        [$keys, $values] = Arr::divide($data);

        $attrs = CategoryAttribute::whereIn('key', $keys)->where('category_id', $product->category_id)->get();

        foreach ($attrs as $attr) {
            $productAttrValue = new ProductAttributeValue();
            $productAttrValue->category_attribute_id = $attr->id;
            $productAttrValue->product_id = $product->id;
            $productAttrValue->value = $data[$attr->key];
            $productAttrValue->save();
        }
    }

    /**
     * Check if owner want to verify the product
     *
     * @param Request $request
     * @param Product $product
     */
    public function checkProductVerification(Request $request)
    {
        if($request['NumMedia'] > 0) {
            $owner = User::where('type', 'owner')->where('phone', $request['From'])->first();

            if($owner) {
                $product = Product::where([
                    'user_id' => $owner->id,
                    'status' => 'pending'
                ])->first();

                if($product) {
                    $product->image = $request['MediaUrl0'];
                    $product->status = Product::BEING_VERIFIED;
                    $product->save();
                }
            }
        }
    }

}
