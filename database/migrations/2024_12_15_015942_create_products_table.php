<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->json('images')->nullable();
            $table->float('origin_price');
            $table->float('current_price');
            $table->json('materials')->nullable();
            $table->string('price_symbol')->default('VND');
            $table->string('product_type');
            $table->boolean('in_stock');
            $table->json('buy_links')->nullable();
            $table->uuid('brand_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
