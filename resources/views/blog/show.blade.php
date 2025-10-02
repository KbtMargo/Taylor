@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div style="max-width:900px;margin:0 auto;padding:20px;">
  <a href="{{ route('blog.index') }}">← До новин</a>
  <h1 style="margin:10px 0 6px 0;">{{ $post->title }}</h1>
  <div style="color:#666;font-size:.95rem;">
    {{ optional($post->published_at)->format('d.m.Y') }} · {{ $post->author->name }}
    @if($post->category) ·
      <a href="{{ route('blog.category',$post->category->slug) }}">{{ $post->category->name }}</a>
    @endif
  </div>

  <div style="margin:14px 0;">
    {!! nl2br(e($post->body)) !!}
  </div>

  <div style="margin:10px 0;display:flex;gap:6px;flex-wrap:wrap;">
    @foreach($post->tags as $t)
      <a href="{{ route('blog.tag',$t->slug) }}" style="background:#eef;padding:3px 8px;border-radius:12px;font-size:.9rem;">
        #{{ $t->name }}
      </a>
    @endforeach
  </div>

  <hr style="margin:18px 0;">

  <h3>Коментарі ({{ $post->comments()->count() }})</h3>

  @auth
    @if (session('status'))
      <div style="background:#e7f5e7;border:1px solid #bfe5bf;padding:8px;border-radius:6px;margin-bottom:8px;">
        {{ session('status') }}
      </div>
    @endif
    <form method="POST" action="{{ route('blog.comment', $post) }}" style="margin-bottom:14px;">
      @csrf
      <textarea name="body" rows="3" style="width:100%;padding:8px;" placeholder="Напишіть коментар...">{{ old('body') }}</textarea>
      @error('body')<div style="color:#b91c1c;">{{ $message }}</div>@enderror
      <button type="submit" style="margin-top:6px;">Надіслати</button>
    </form>
  @else
    <p>Щоб коментувати — <a href="{{ route('login') }}">увійдіть</a> або <a href="{{ route('register') }}">зареєструйтесь</a>.</p>
  @endauth

  <div style="display:flex;flex-direction:column;gap:10px;">
    @forelse($post->comments as $c)
      <div style="border:1px solid #eee;border-radius:8px;padding:10px;background:#fff;">
        <div style="font-size:.9rem;color:#666;">
          {{ $c->user?->name ?? $c->author_name ?? 'Користувач' }}
          · {{ $c->created_at->diffForHumans() }}
        </div>
        <div>{{ $c->body }}</div>
      </div>
    @empty
      <p>Коментарів ще немає.</p>
    @endforelse
  </div>

  @if($related->count())
    <hr style="margin:18px 0;">
    <h3>Ще по темі</h3>
    <ul>
      @foreach($related as $r)
        <li><a href="{{ route('blog.show',$r->slug) }}">{{ $r->title }}</a></li>
      @endforeach
    </ul>
  @endif
</div>
@endsection
