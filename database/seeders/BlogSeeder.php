<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Editor',
            'email'=> 'editor@example.com'
        ]);

        $categories = collect(['Новини','Поради','Огляди'])->map(function($n){
            return Category::firstOrCreate(
                ['slug' => Str::slug($n)],
                ['name' => $n]
            );
        });

        $tags = collect(['матеріали','тренди','ательє','шиття'])->map(function($n){
            return Tag::firstOrCreate(
                ['slug' => Str::slug($n)],
                ['name' => ucfirst($n)]
            );
        });

        for ($i=1; $i<=6; $i++) {
            $title = "Пост №$i: оновлення платформи";
            $post = Post::create([
                'user_id'     => $user->id,
                'category_id' => $categories->random()->id,
                'title'       => $title,
                'slug'        => Str::slug($title)."-".$i,
                'excerpt'     => 'Короткий опис новини про оновлення і матеріали.',
                'body'        => 'Повний текст новини. Тут може бути markdown/HTML з деталями.',
                'published_at'=> now()->subDays(rand(0,10)),
            ]);
            $post->tags()->sync($tags->random(rand(1,3))->pluck('id'));
        }
    }
}
