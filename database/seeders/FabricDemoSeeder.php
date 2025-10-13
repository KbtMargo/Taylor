<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FabricDemoSeeder extends Seeder
{
    public function run(): void
    {
        $makeUniqueSlug = function (string $table, string $column, string $base) {
            $slug = Str::slug($base);
            if ($slug === '') { $slug = Str::slug(uniqid($base.'-')); }

            $i = 1;
            while (DB::table($table)->where($column, $slug)->exists()) {
                $slug = Str::slug($base).'-'.$i++;
            }
            return $slug;
        };

        // --- Categories: додаємо slug, якщо така колонка існує ---
        $categoryPayload = ['name' => 'Тканини'];
        if (Schema::hasColumn('categories', 'slug')) {
            $categoryPayload['slug'] = $makeUniqueSlug('categories', 'slug', $categoryPayload['name']);
        }

        $categoryId = DB::table('categories')->insertGetId($categoryPayload);

        $materials = [
            [
                'name' => 'Трикотаж Бавовна',
                'image' => '/images/Трикотаж бававна.jpg',
                'colors' => 'Білий, Рожевий, Синій +1',
                'delivery' => '2-3 дні',
                'price' => '320 грн/м',
                'in_stock' => true,
            ],
            [
                'name' => 'Вовна Костюмна',
                'image' => '/images/Вовна костюмна.jpg',
                'colors' => 'Синій, Сірий, Зелений +1',
                'delivery' => '5-7 днів',
                'price' => '500 грн/м',
                'in_stock' => true,
            ],
            [
                'name' => 'Шовк Принт',
                'image' => '/images/Шовк принт.jpg',
                'colors' => 'Білий, Кремовий, Сірий +2',
                'delivery' => '3-5 днів',
                'price' => '420 грн/м',
                'in_stock' => true,
            ],
            [
                'name' => 'Підкладка Віскоза',
                'image' => '/images/Підкладка віскоза.jpg',
                'colors' => 'Білий, Кремовий, Бежевий +1',
                'delivery' => '1-2 дні',
                'price' => '200 грн/м',
                'in_stock' => true,
            ],
            [
                'name' => 'Льон Класичний',
                'image' => '/images/93bbdc587cbc2ee06b56b3ce27ef4dcc.jpg',
                'colors' => 'Бежевий, Коричневий, Темно-синій +2',
                'delivery' => '4-6 днів',
                'price' => '300 грн/м',
                'in_stock' => false,
            ],
            [
                'name' => 'Шкіра Еко',
                'image' => '/images/Шкіра еко.jpg',
                'colors' => 'Бежевий, Коричневий, Темно-червоний +1',
                'delivery' => '3-5 днів',
                'price' => '550 грн/м',
                'in_stock' => true,
            ],
        ];

        foreach ($materials as $m) {
            $pricePerM = (float) preg_replace('/[^\d\.]/u', '', str_replace(',', '.', $m['price']));

            $productPayload = [
                'category_id' => $categoryId,
                'name'        => $m['name'],
                'description' => ($m['colors'] ?? '') . (isset($m['delivery']) ? ' · Доставка: '.$m['delivery'] : ''),
                'price_per_m' => $pricePerM,
                'stock_m'     => !empty($m['in_stock']) ? 100 : 0,
                'color'       => null,
                'width_cm'    => null,
                'material'    => null,
                'sku'         => Str::slug($m['name']),
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            if (Schema::hasColumn('products', 'slug')) {
                $productPayload['slug'] = $makeUniqueSlug('products', 'slug', $productPayload['name']);
            }

            $productId = DB::table('products')->insertGetId($productPayload);

            DB::table('product_images')->insert([
                'product_id' => $productId,
                'url'        => $m['image'],
                'alt_text'   => $m['name'],
                'sort_order' => 1,
            ]);
        }
    }
}
