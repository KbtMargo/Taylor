<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Перевіряємо чи існує таблиця products
        if (!Schema::hasTable('products')) {
            $this->command->error('Products table does not exist! Please run migrations first.');
            return;
        }

        // Отримуємо або створюємо категорію
        $category = DB::table('categories')->first();
        if (!$category) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => 'Тканини',
                'slug' => 'tkanini',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $categoryId = $category->id;
        }

        $products = [
            [
                'name' => 'Бавовняна тканина "Львів"',
                'category_id' => $categoryId,
                'description' => 'Якісна бавовняна тканина українського виробництва.',
                'price_per_m' => 89.50,
                'stock_m' => 45.2,
                'color' => 'Білий',
                'width_cm' => 150,
                'material' => 'Бавовна 100%',
                'sku' => 'TIS-001',
                'is_active' => true,
            ],
            [
                'name' => 'Шовкова тканина "Карпати"',
                'category_id' => $categoryId,
                'description' => 'Розкішна шовкова тканина для вечірніх суконь.',
                'price_per_m' => 450.00,
                'stock_m' => 12.5,
                'color' => 'Сливовий',
                'width_cm' => 140,
                'material' => 'Шовк 100%',
                'sku' => 'TIS-002',
                'is_active' => true,
            ],
            [
                'name' => 'Джинсова тканина "Дніпро"',
                'category_id' => $categoryId,
                'description' => 'Міцна джинсова тканина для джинсів та курток.',
                'price_per_m' => 120.00,
                'stock_m' => 28.7,
                'color' => 'Синій',
                'width_cm' => 150,
                'material' => 'Бавільна 98%, Еластан 2%',
                'sku' => 'TIS-003',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            // Генеруємо slug
            $slug = Str::slug($product['name']);
            
            // Перевіряємо унікальність slug
            $counter = 1;
            $originalSlug = $slug;
            while (DB::table('products')->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Вставляємо продукт
            DB::table('products')->insert([
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => $slug,
                'description' => $product['description'],
                'price_per_m' => $product['price_per_m'],
                'stock_m' => $product['stock_m'],
                'color' => $product['color'],
                'width_cm' => $product['width_cm'],
                'material' => $product['material'],
                'sku' => $product['sku'],
                'is_active' => $product['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Successfully seeded ' . count($products) . ' products!');
    }
}