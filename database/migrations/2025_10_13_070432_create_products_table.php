<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name', 160);
            $table->string('slug', 160)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price_per_m', 10, 2);
            $table->decimal('stock_m', 10, 2)->default(0);
            $table->string('color', 120)->nullable();
            $table->integer('width_cm')->nullable();
            $table->string('material', 120)->nullable();
            $table->string('sku', 64)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('price_per_m');
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};