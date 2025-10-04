<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('atelier_photos')) {
            return;
        }

        // 1) Додаємо відсутні колонки
        Schema::table('atelier_photos', function (Blueprint $t) {
            if (!Schema::hasColumn('atelier_photos', 'is_published')) {
                $t->boolean('is_published')->default(true)->after('image_path');
            }
            if (!Schema::hasColumn('atelier_photos', 'sort_order')) {
                $t->unsignedInteger('sort_order')->nullable()->after('is_published');
            }
        });

        // 2) Якщо є стара колонка 'published', перенесемо значення
        if (Schema::hasColumn('atelier_photos', 'published') && Schema::hasColumn('atelier_photos', 'is_published')) {
            DB::statement('UPDATE atelier_photos SET is_published = published WHERE published IS NOT NULL');
        }

        // (необов’язково) Можеш відразу дропнути стару колонку 'published':
        // Schema::table('atelier_photos', function (Blueprint $t) {
        //     if (Schema::hasColumn('atelier_photos', 'published')) {
        //         $t->dropColumn('published');
        //     }
        // });
    }

    public function down(): void
    {
        if (!Schema::hasTable('atelier_photos')) {
            return;
        }

        Schema::table('atelier_photos', function (Blueprint $t) {
            if (Schema::hasColumn('atelier_photos', 'sort_order')) {
                $t->dropColumn('sort_order');
            }
            if (Schema::hasColumn('atelier_photos', 'is_published')) {
                $t->dropColumn('is_published');
            }
        });
    }
};
