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
            $table->id('id_product');
            $table->string('product_name');
            $table->text('description');
            $table->integer('price');
            $table->string('product_image')->nullable();
            $table->integer('stock');
            $table->unsignedBigInteger('id_category');
            $table->string('product_status');
            $table->foreignId("id_user")->constrained("users");
            $table->timestamps();

            $table->foreign('id_category')->references('id_categories')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.//
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
