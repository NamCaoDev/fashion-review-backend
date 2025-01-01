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
        Schema::create('brands', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->enum('type', ['local', 'global'])->default('local');
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('established_at')->nullable();
            $table->string('founder')->nullable();
            $table->json('addresses')->nullable();
            $table->string('logo')->default('https://m.yodycdn.com/blog/anh-luffy-yody-vn-65.jpg');
            $table->json('social_links')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
