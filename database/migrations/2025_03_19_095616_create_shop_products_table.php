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
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->integer('cost');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('shop_categories')->onDelete('cascade')->onUpdate('restrict');
        });

        Schema::create('shop_orders', function (Blueprint $table) {
            $table->id();
            $table->text('note');
            $table->integer('current_status');
            $table->string('customer_name');
            $table->timestamps();
        });

        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('shop_orders')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade')->onUpdate('restrict');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_order_items');
        Schema::dropIfExists('shop_orders');
        Schema::dropIfExists('shop_products');
    }
};
