<?php

namespace App\Http\Controllers\Atelier;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $r)
    {
        $posts = Post::query()
            ->search($r->get('q'))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('atelier.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('atelier.posts.form', ['post' => new Post()]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'title' => ['required','string','max:255'],
            'slug'  => ['nullable','string','max:255','unique:posts,slug'],
            'body'  => ['required','string'],
            'status'=> ['nullable','string','in:draft,published'],
            'published_at' => ['nullable','date'],
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']).'-'.Str::random(6);

        $post = Post::create($data);
        return redirect()->route('atelier.posts.edit', $post)->with('ok','Створено');
    }

    public function show(Post $post) { return view('atelier.posts.show', compact('post')); }

    public function edit(Post $post) { return view('atelier.posts.form', compact('post')); }

    public function update(Request $r, Post $post)
    {
        $data = $r->validate([
            'title' => ['required','string','max:255'],
            'slug'  => ['required','string','max:255', Rule::unique('posts','slug')->ignore($post->id)],
            'body'  => ['required','string'],
            'status'=> ['nullable','string','in:draft,published'],
            'published_at' => ['nullable','date'],
        ]);
        $post->update($data);
        return back()->with('ok','Збережено');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('atelier.posts.index')->with('ok','Видалено');
    }
}
