<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('ateliers', 'slug')) {
            Schema::table('ateliers', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });
        }

        DB::table('ateliers')
            ->select(['id','name','slug'])
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    if (!empty($row->slug)) continue;

                    $base = Str::slug($row->name ?? 'atelier-'.$row->id);
                    $slug = $base;

                    $suffix = 1;
                    while (DB::table('ateliers')->where('slug', $slug)->exists()) {
                        $slug = $base.'-'.$suffix++;
                    }

                    DB::table('ateliers')->where('id', $row->id)->update(['slug' => $slug]);
                }
            });

    }

    public function down(): void
    {
        if (Schema::hasColumn('ateliers', 'slug')) {
            Schema::table('ateliers', function (Blueprint $table) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            });
        }
    }
};
