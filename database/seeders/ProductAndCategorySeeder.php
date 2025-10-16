<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;

class ProductAndCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Category::truncate();
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $category = Category::create(['name' => 'Тканини']);

        $materials = [
            [
                'name' => 'Трикотаж Бавовна',
                'image' => '/images/trikotazh-bavovna.jpg',
                'description' => 'М\'який та еластичний трикотаж, ідеально підходить для пошиття повсякденного одягу, футболок та дитячих речей.',
                'price' => '320', 'stock_m' => 50,
                'material' => '95% бавовна, 5% еластан', 'color' => 'Білий', 'width_cm' => 180, 'sku' => 'TB-001',
            ],
            [
                'name' => 'Вовна Костюмна',
                'image' => '/images/vovna-costumna.jpg',
                'description' => 'Класична костюмна тканина з вовни, добре тримає форму, підходить для пошиття костюмів, спідниць та брюк.',
                'price' => '500', 'stock_m' => 30,
                'material' => '80% вовна, 20% поліестер', 'color' => 'Темно-синій', 'width_cm' => 150, 'sku' => 'VK-002',
            ],
            [
                'name' => 'Шовк Принт',
                'image' => '/images/shovk-print.jpg',
                'description' => 'Легкий та повітряний шовк з елегантним принтом для блуз, суконь та шарфів.',
                'price' => '420', 'stock_m' => 45,
                'material' => '100% шовк Армані', 'color' => 'Кремовий з принтом', 'width_cm' => 140, 'sku' => 'SP-003',
            ],
            [
                'name' => 'Підкладка Віскоза',
                'image' => '/images/pidkladks-viskoza.jpg',
                'description' => 'Гладка та дихаюча підкладкова тканина з віскози, забезпечує комфорт при носінні верхнього одягу.',
                'price' => '200', 'stock_m' => 150,
                'material' => '100% віскоза', 'color' => 'Бежевий', 'width_cm' => 150, 'sku' => 'PV-004',
            ],
            [
                'name' => 'Льон Класичний',
                'image' => '/images/lyon.jpg',
                'description' => 'Натуральна лляна тканина, ідеальна для літнього одягу. Має характерну фактуру.',
                'price' => '300', 'stock_m' => 0, 
                'material' => '100% льон', 'color' => 'Натуральний (беж)', 'width_cm' => 145, 'sku' => 'LK-005',
            ],
            [
                'name' => 'Шкіра Еко',
                'image' => '/images/shkira-eco.jpg',
                'description' => 'Високоякісна еко-шкіра на трикотажній основі. Еластична та стійка до зношування.',
                'price' => '550', 'stock_m' => 25,
                'material' => 'Поліуретан, поліестер', 'color' => 'Чорний', 'width_cm' => 140, 'sku' => 'SE-006',
            ],
        ];

        foreach ($materials as $material) {
            Product::create([
                'category_id' => $category->category_id,
                'name'        => $material['name'],
                'image'       => $material['image'],
                'description' => $material['description'],
                'price_per_m' => (float)$material['price'],
                'stock_m'     => (float)$material['stock_m'],
                'is_active'   => true,
                'material'    => $material['material'],
                'color'       => $material['color'],
                'width_cm'    => $material['width_cm'],
                'sku'         => $material['sku'],
            ]);
        }
    }
}

