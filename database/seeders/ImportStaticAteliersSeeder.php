<?php

namespace Database\Seeders;

use App\Models\Atelier;
use Illuminate\Database\Seeder;

class ImportStaticAteliersSeeder extends Seeder
{
    public function run(): void
    {
        $items = (new \App\Http\Controllers\AtelierController)->data(); // беремо твій масив

        foreach ($items as $a) {
            // створюємо/оновлюємо запис за slug (ключ)
            Atelier::updateOrCreate(
                ['slug' => $a['slug']],
                [
                    'name'        => $a['name'] ?? null,
                    'phone'       => $a['phone'] ?? null,
                    'address'     => $a['address'] ?? null,
                    'description' => $a['about'] ?? null,
                ]
            );
        }
    }
}
