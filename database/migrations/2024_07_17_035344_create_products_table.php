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
            $table->id();
            $table->string('product_name');
            $table->Integer('price')->default(0);
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('jan_code', 20)->nullable();
            $table->string('category', 50)->nullable();
            $table->string('tags', 50)->nullable();
            $table->text('remarks')->nullable();
            $table->Integer('store_id')->default(0);
            $table->tinyInteger('public_flg')->default(0);
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('created_by', 20)->default("");
            $table->string('updated_by', 20)->default("");
            $table->timestamps();
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
