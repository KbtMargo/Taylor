<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1) додамо колонку, якщо її ще немає
        if (!Schema::hasColumn('ateliers', 'slug')) {
            Schema::table('ateliers', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });
        }

        // 2) бекап-філл існуючих записів
        DB::table('ateliers')
            ->select(['id','name','slug'])
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    if (!empty($row->slug)) continue;

                    $base = Str::slug($row->name ?? 'atelier-'.$row->id);
                    $slug = $base;

                    // уникаємо колізій
                    $suffix = 1;
                    while (DB::table('ateliers')->where('slug', $slug)->exists()) {
                        $slug = $base.'-'.$suffix++;
                    }

                    DB::table('ateliers')->where('id', $row->id)->update(['slug' => $slug]);
                }
            });

        // залишимо nullable (не обов'язково змінювати на NOT NULL, щоб не тягнути doctrine/dbal)
    }

    public function down(): void
    {
        // обережно: видаляти колонку можна, якщо потрібно
        if (Schema::hasColumn('ateliers', 'slug')) {
            Schema::table('ateliers', function (Blueprint $table) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            });
        }
    }
};
