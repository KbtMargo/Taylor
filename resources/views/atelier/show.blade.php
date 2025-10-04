@extends('layouts.app')

@section('title', $atelier['name'].' | Ательє')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:20px;">
    <a href="{{ route('page.atelier') }}" style="display:inline-flex; align-items:center; gap:6px; text-decoration:none; color:#2563eb; margin-bottom:15px;">
        ← Повернутися до списку
    </a>

    <div style="display:flex; gap:20px; align-items:flex-start; background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:20px;">
        <img src="{{ $atelier['image'] }}" alt="{{ $atelier['name'] }}" style="width:260px; height:260px; object-fit:cover; border-radius:10px;">
        <div style="flex:1;">
            <h1 style="margin:0 0 10px 0;">{{ $atelier['name'] }}</h1>

            <div style="display:grid; grid-template-columns:160px 1fr; gap:6px 16px; margin-bottom:12px;">
                <div><strong>Адреса:</strong></div>
                <div>{{ $atelier['address'] }}</div>

                <div><strong>Email:</strong></div>
                <div><a href="mailto:{{ $atelier['email'] }}">{{ $atelier['email'] }}</a></div>

                <div><strong>Телефон:</strong></div>
                <div><a href="tel:{{ preg_replace('/\s+/', '', $atelier['phone']) }}">{{ $atelier['phone'] }}</a></div>
            </div>

            @if(!empty($atelier['work_hours']))
                <div style="margin:10px 0 14px 0;">
                    <strong>Години роботи:</strong>
                    <ul style="margin:6px 0 0 0; padding-left:16px;">
                        @foreach($atelier['work_hours'] as $day => $hours)
                            <li>{{ $day }} — {{ $hours }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($atelier['tags']))
                <div style="margin:10px 0;">
                    <strong>Теги:</strong>
                    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:6px;">
                        @foreach($atelier['tags'] as $key => $values)
                            @foreach($values as $value)
                                <span style="background:#007bff; color:#fff; padding:4px 10px; border-radius:16px; font-size:0.85rem;">
                                    {{ $value }}
                                </span>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if(!empty($atelier['about']))
        <div style="margin-top:20px; background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:20px;">
            <h2 style="margin-top:0;">Про ательє</h2>
            <p style="margin:0;">{{ $atelier['about'] }}</p>
        </div>
    @endif

    @if(!empty($atelier['gallery']) || $atelier->photos()->published()->count() > 0)
        <h2 class="text-xl font-semibold mb-3">Галерея</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($atelier->photos()->published()->orderBy('sort_order')->latest('id')->take(12)->get() as $p)
            {{-- ВИПРАВЛЕНО: передано ID --}}
            <a href="{{ route('ateliers.photos.edit', [$atelier['id'],$p]) }}" class="block">
            <img src="{{ $p->image_path }}" alt="{{ $p->title }}" class="w-full h-40 object-cover rounded"/>
            <div class="text-sm mt-1">{{ $p->title }}</div>
            </a>
        @empty
            <div class="col-span-full text-gray-500">Поки що немає фото</div>
        @endforelse
        </div>
        
        {{-- ВИПРАВЛЕНО: передано ID --}}
        <a class="btn btn-primary mt-4" href="{{ route('ateliers.photos.index', $atelier['id']) }}">Управління фото</a>
        
        <h2 class="text-xl font-semibold mt-8 mb-3">Відгуки</h2>
        @auth
        {{-- ВИПРАВЛЕНО: передано ID --}}
        <form method="post" action="{{ route('ateliers.comments.store', $atelier['id']) }}" class="mb-4">
          @csrf
          <div class="flex items-center gap-3 mb-2">
            <label>Оцінка:</label>
            <select name="rating" class="input">
              <option value="">—</option>
              @for($i=1;$i<=5;$i++) <option value="{{ $i }}">{{ $i }}</option> @endfor
            </select>
          </div>
          <textarea name="body" rows="4" class="input w-full" placeholder="Ваш відгук..." required></textarea>
          <button class="btn btn-primary mt-2">Надіслати</button>
        </form>
        @endauth

        @forelse($atelier->comments()->latest()->get() as $c)
          <div class="border-t py-3">
            <div class="text-sm text-gray-500">
              {{ $c->user->name ?? 'Гість' }}
              @if($c->rating) • ★ {{ $c->rating }} @endif
              • {{ $c->created_at->diffForHumans() }}
            </div>
            <div>{{ $c->body }}</div>
          </div>
        @empty
          <div class="text-gray-500">Ще немає відгуків</div>
        @endforelse
    @endif
</div>
@endsection