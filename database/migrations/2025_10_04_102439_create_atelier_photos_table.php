<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void {
        Schema::create('atelier_photos', function (Blueprint $t) {
            $t->id();
            $t->foreignId('atelier_id')->constrained('ateliers')->cascadeOnDelete();
            $t->string('title')->nullable();
            $t->string('slug')->unique();
            $t->string('image_path');            // storage path (public)
            $t->text('description')->nullable(); // опис
            $t->enum('status', ['draft','published'])->default('draft');
            $t->timestamp('published_at')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
            $t->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('atelier_photos'); }
};
