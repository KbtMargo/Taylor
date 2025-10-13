<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Тканини'],
            ['name' => 'Нитки'],
            ['name' => 'Фурнітура'],
            ['name' => 'Інструменти'],
            ['name' => 'Готові вироби'],
        ];

        $insertedCount = 0;
        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);
            
            $exists = DB::table('categories')
                ->where('slug', $slug)
                ->orWhere('name', $category['name'])
                ->exists();

            if (!$exists) {
                $counter = 1;
                $originalSlug = $slug;
                while (DB::table('categories')->where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                DB::table('categories')->insert([
                    'name' => $category['name'],
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $insertedCount++;
            }
        }

        $this->command->info("CategorySeeder: {$insertedCount} new categories added");
    }
}