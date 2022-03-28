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
        $currentMicroTime = (int) (microtime(true) * 10000);

        $upserts = array_map(function($price) use ($currentMicroTime, $product) {
            return [
                'guid' => $price['guid'],
                'amount' => $price['price'],
                'product_guid' => $product->guid,
                'last_updated_at' => $currentMicroTime
            ];
        }, $request->prices);

        Price::upsert($upserts, ['guid', 'product_guid'], ['amount', 'last_updated_at']);

        Price::where('product_guid', $product->guid)
            ->where('last_updated_at', '<', $currentMicroTime)
            ->delete();

        return new SuccessResponseResource([]);
    }
}
