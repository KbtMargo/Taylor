<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $categories = Category::factory()->count(5)->create();

        // 20 постів, частина опубліковані
        $posts = Post::factory()->count(20)->create([
            // Якщо хочеш, щоб автором точно був $admin:
            // 'user_id' => $admin->id,
            // 'category_id' => $categories->random()->id, // якщо не хочеш Category::factory() у PostFactory
        ]);

        $tags = Tag::factory()->count(10)->create();

        // Прикріпимо 0–3 теги до кожного поста
        foreach ($posts as $post) {
            $post->tags()->sync(
                $tags->random(rand(0, 3))->pluck('id')->all()
            );

            // 0–2 коментарі
            Comment::factory()->count(rand(0, 2))->create([
                'post_id' => $post->id,
            ]);
        }
    }
}
