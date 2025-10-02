@extends('layouts.app')

@section('title','Новини')

@section('content')
<div style="max-width:1100px;margin:0 auto;padding:20px;">
  <h1>Новини</h1>

  <form method="GET" action="{{ route('blog.index') }}" style="margin:12px 0;">
    <input type="text" name="q" value="{{ $search }}" placeholder="Пошук..." style="padding:6px 10px;width:240px;">
    <button type="submit">Знайти</button>
  </form>

  <div style="display:flex;gap:20px;align-items:flex-start;">
    <aside style="width:220px;">
      <h3>Категорії</h3>
      <ul>
        @foreach($categories as $c)
          <li>
            <a href="{{ route('blog.category',$c->slug) }}"
               @style(['font-weight:bold' => isset($activeCategory) && $activeCategory->id === $c->id])>
              {{ $c->name }}
            </a>
          </li>
        @endforeach
      </ul>
      <h3 style="margin-top:12px;">Теги</h3>
      <div style="display:flex;gap:6px;flex-wrap:wrap;">
        @foreach($tags as $t)
          <a href="{{ route('blog.tag',$t->slug) }}" style="background:#eef; padding:3px 8px; border-radius:12px; font-size:.9rem;">
            #{{ $t->name }}
          </a>
        @endforeach
      </div>
    </aside>

    <main style="flex:1;">
      @if($posts->count())
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;">
          @foreach($posts as $p)
            <article style="border:1px solid #eee;border-radius:10px;padding:12px;background:#fff;">
              <h2 style="margin:0 0 6px 0;">
                <a href="{{ route('blog.show',$p->slug) }}">{{ $p->title }}</a>
              </h2>
              <div style="color:#666;font-size:.9rem;margin-bottom:6px;">
                {{ optional($p->published_at)->format('d.m.Y') }} · {{ $p->author->name }}
              </div>
              <p style="margin:0 0 8px 0;">{{ $p->excerpt }}</p>
              @if($p->category)
                <a href="{{ route('blog.category',$p->category->slug) }}" style="font-size:.85rem;">{{ $p->category->name }}</a>
              @endif
              <div style="margin-top:6px;display:flex;gap:6px;flex-wrap:wrap;">
                @foreach($p->tags as $t)
                  <a href="{{ route('blog.tag',$t->slug) }}" style="background:#f3f4f6;padding:2px 8px;border-radius:10px;font-size:.8rem;">
                    #{{ $t->name }}
                  </a>
                @endforeach
              </div>
            </article>
          @endforeach
        </div>

        <div style="margin-top:14px;">
          {{ $posts->links() }}
        </div>
      @else
        <p>Нічого не знайдено.</p>
      @endif
    </main>
  </div>
</div>
@endsection
