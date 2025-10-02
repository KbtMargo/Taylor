<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(5);
        return [
            'user_id'      => User::factory(),
            'category_id'  => Category::factory(),
            'title'        => $title,
            'slug'         => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1000, 999999),
            'excerpt'      => $this->faker->paragraph(),
            'body'         => $this->faker->paragraphs(5, true),
            'published_at' => now()->subDays($this->faker->numberBetween(0, 10)),
        ];
    }
}
