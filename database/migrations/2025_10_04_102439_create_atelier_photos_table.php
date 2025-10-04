<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('atelier_photos', function (Blueprint $t) {
            $t->id();
            $t->foreignId('atelier_id')->constrained()->cascadeOnDelete();
            $t->string('title')->nullable();
            $t->string('image_path');
            $t->boolean('is_published')->default(true);
            $t->unsignedInteger('sort_order')->nullable();
            $t->timestamps();
            $t->index(['atelier_id','is_published','sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atelier_photos');
    }
};
