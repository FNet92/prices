<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->uuid('guid')->primary();
            $table->float('amount');
            $table->uuid('product_guid');

            $table->foreign('product_guid')->references('guid')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prices');
    }
};
