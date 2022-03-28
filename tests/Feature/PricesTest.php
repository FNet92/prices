<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Support\Str;
use Tests\TestCase;

class PricesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_prices()
    {
        $response = $this->getJson('/api/prices')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'guid',
                        'amount',
                        'product_guid'
                    ]
                ]
            ]);
    }

    public function test_set_prices()
    {
        $product = Product::factory()->create();

        $this->putJson("/api/prices/{$product->guid}",
            [
                "prices" => [
                    [
                        "guid" => Str::uuid(),
                        "price" => rand(1, 500000)
                    ],
                    [
                        "guid" => Str::uuid(),
                        "price" => rand(1, 500000)
                    ]

                ]
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'result'
                ]
            ]);

        $this->assertEquals(2, Price::where('product_guid', $product->guid)->count());
    }

    public function test_set_prices_invalid_guid()
    {
        $product = Product::factory()->create();

        $this->putJson("/api/prices/{$product->guid}",
            [
                "prices" => [
                    [
                        "guid" => 'invalid-uuid',
                        "price" => rand(1, 500000)
                    ]
                ]
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'code', 'code_message', 'error'
            ]);

        $this->assertEquals(0, Price::where('product_guid', $product->guid)->count());
    }
}
