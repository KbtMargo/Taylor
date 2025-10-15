<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

class ProductAndCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Category::truncate();
        Product::truncate();
        ProductImage::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $category = Category::create(['name' => 'Тканини']);

        $materials = [
            [
                'name' => 'Трикотаж Бавовна', 'image' => '/images/trikotazh-bavovna.jpg', 'description' => 'Білий, Рожевий, Синій +1 · Доставка: 2-3 дні',
                'price' => '320', 'in_stock' => true,
            ],
            [
                'name' => 'Вовна Костюмна', 'image' => '/images/vovna-kostumna.jpg', 'description' => 'Синій, Сірий, Зелений +1 · Доставка: 5-7 днів',
                'price' => '500', 'in_stock' => true,
            ],
            [
                'name' => 'Шовк Принт', 'image' => '/images/shovk-print.jpg', 'description' => 'Білий, Кремовий, Сірий +2 · Доставка: 3-5 днів',
                'price' => '420', 'in_stock' => true,
            ],
            [
                'name' => 'Підкладка Віскоза', 'image' => '/images/pidkladka-viskoza.jpg', 'description' => 'Білий, Кремовий, Бежевий +1 · Доставка: 1-2 дні',
                'price' => '200', 'in_stock' => true,
            ],
            [
                'name' => 'Льон Класичний', 'image' => '/images/lyon.jpg', 'description' => 'Бежевий, Коричневий, Темно-синій +2 · Доставка: 4-6 днів',
                'price' => '300', 'in_stock' => false,
            ],
            [
                'name' => 'Шкіра Еко', 'image' => '/images/shkiro-eco.jpg', 'description' => 'Бежевий, Коричневий, Темно-червоний +1 · Доставка: 3-5 днів',
                'price' => '550', 'in_stock' => true,
            ],
        ];

        foreach ($materials as $material) {
            $product = Product::create([
                'category_id' => $category->category_id,
                'name' => $material['name'],
                'description' => $material['description'],
                'price_per_m' => (float)$material['price'],
                'stock_m' => $material['in_stock'] ? rand(10, 100) : 0,
                'is_active' => true,
            ]);

            ProductImage::create([
                'product_id' => $product->product_id,
                'url' => $material['image'],
                'alt_text' => $material['name'],
                'sort_order' => 1,
            ]);
        }
    }
}
