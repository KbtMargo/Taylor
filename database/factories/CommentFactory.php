<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(), // або заміниш на існуючий post_id у сидері
            'body'    => $this->faker->sentences(2, true),
        ];
    }
}
