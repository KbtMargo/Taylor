<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $posts = Post::query()
            ->with(['category', 'tags', 'author']) 
            ->when($q, function ($query, $q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('title', 'like', "%{$q}%")
                       ->orWhere('excerpt', 'like', "%{$q}%")
                       ->orWhere('body', 'like', "%{$q}%");
                });
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('blog.index', compact('posts', 'categories', 'tags', 'q'));
    }

    public function show(string $slug)
    {
        $post = Post::with(['category', 'tags', 'author', 'comments.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Post::where('category_id', $post->category_id)
            ->where('id', '<>', $post->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('blog.show', compact('post', 'related'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::with(['category','tags','author'])
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', [
            'posts' => $posts,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'q' => null,
            'activeCategory' => $category,
        ]);
    }

    public function tag(string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = Post::with(['category','tags','author'])
            ->whereHas('tags', fn($q) => $q->where('slug', $slug))
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', [
            'posts' => $posts,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'q' => null,
            'activeTag' => $tag,
        ]);
    }
    
}
