<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $t) {
            $t->foreignId('atelier_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $t->boolean('is_default')->default(false)->after('slug');

            $t->unique(['atelier_id', 'is_default']);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $t) {
            $t->dropUnique(['atelier_id','is_default']);
            $t->dropConstrainedForeignId('atelier_id');
            $t->dropColumn('is_default');
        });
    }
};
