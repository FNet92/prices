<?php

namespace App\Http\Controllers;

use App\Http\Requests\PricesUpdateRequest;
use App\Http\Resources\PriceResource;
use App\Http\Resources\SuccessResponseResource;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PricesController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $prices = Price::paginate(10);

        return PriceResource::collection($prices);
    }

    public function update(PricesUpdateRequest $request, Product $product): SuccessResponseResource
    {
        $product->prices()->delete();

        foreach (array_chunk($request->prices, 200) as $prices) {
            $pricesBatchInsert = array_map(function($price) use ($product) {
                return [
                    'guid' => $price['guid'],
                    'amount' => $price['price'],
                    'product_guid' => $product->guid
                ];
            }, $prices);

            Price::insert($pricesBatchInsert);
        }


        return new SuccessResponseResource([]);
    }
}
