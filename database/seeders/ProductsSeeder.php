<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{

    public function run(): void
    {
        Product::factory()
            ->count(10)
            ->hasPrices(100)
            ->create();
    }
}
