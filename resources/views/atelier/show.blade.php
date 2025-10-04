@extends('layouts.app')

@section('title', ($atelier['name'] ?? 'Ательє').' | Ательє')

@section('content')
@php
$slug = is_array($atelier) ? ($atelier['slug'] ?? null) : ($atelier->slug ?? null);
/** @var \App\Models\Atelier|null $realAtelier */
$realAtelier = $slug ? \App\Models\Atelier::where('slug', $slug)->first() : null;

$get = fn($key, $fallback='') => is_array($atelier) ? ($atelier[$key] ?? $fallback) : ($atelier->{$key} ?? $fallback);

@endphp

<div class="container py-4">
@if(session('ok'))
<div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <div class="fw-bold mb-1">У формі є помилки:</div>
        <ul class="mb-0">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<a href="{{ route('page.atelier') }}" class="text-primary text-decoration-none mb-4 d-inline-block">
    ← Повернутися до списку
</a>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-4 align-items-start">

            <div class="col-md-4 col-lg-3">
                <img src="{{ $get('image', asset('images/placeholder.jpg')) }}"
                     alt="{{ $get('name','Ательє') }}"
                     class="img-fluid rounded"
                     style="object-fit:cover; height:250px; width:100%;">
            </div>

            <div class="col-md-8 col-lg-9">
                <h1 class="h3 mb-3">{{ $get('name','Ательє') }}</h1>

                <dl class="row mb-4 border-bottom pb-3">
                    <dt class="col-sm-3 fw-bold text-muted">Адреса:</dt>
                    <dd class="col-sm-9">{{ $get('address','Не вказано') }}</dd>

                    <dt class="col-sm-3 fw-bold text-muted">Email:</dt>
                    <dd class="col-sm-9">
                        @php $email = $get('email'); @endphp
                        <a href="mailto:{!! e($email) !!}" class="text-primary">
                            {{ $email ?: 'Не вказано' }}
                        </a>
                    </dd>

                    <dt class="col-sm-3 fw-bold text-muted">Телефон:</dt>
                    <dd class="col-sm-9">
                        @php $phone = $get('phone'); @endphp
                        <a href="tel:{{ preg_replace('/\D+/', '', $phone ?? '') }}" class="text-primary">
                            {{ $phone ?: 'Не вказано' }}
                        </a>
                    </dd>
                </dl>

                @php $hours = $get('work_hours'); @endphp
                @if(!empty($hours) && is_array($hours))
                    <div class="mb-3">
                        <strong class="text-muted">Години роботи:</strong>
                        <ul class="mt-1 ps-4 text-secondary">
                            @foreach($hours as $day => $h)
                                <li>{{ $day }} — {{ $h }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php $tags = $get('tags'); @endphp
                @if(!empty($tags) && is_array($tags))
                    <div class="mt-3">
                        <strong class="text-muted">Теги:</strong>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($tags as $values)
                                @if(is_array($values))
                                    @foreach($values as $value)
                                        <span class="badge bg-primary rounded-pill shadow-sm">{{ $value }}</span>
                                    @endforeach
                                @else
                                    <span class="badge bg-primary rounded-pill shadow-sm">{{ $values }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@php $about = $get('about'); @endphp
@if(!empty($about))
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h4 mb-3">Про ательє</h2>
            <p class="text-secondary">{{ $about }}</p>
        </div>
    </div>
@endif

@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

$photos = collect();

if ($realAtelier) {
    $photos = DB::table('atelier_photos')
        ->where('atelier_id', $realAtelier->id)
        ->where('is_published', 1)                      
        ->orderByRaw('sort_order IS NULL, sort_order ASC')
        ->orderByDesc('id')
        ->limit(12)
        ->get();
}
@endphp
    
<h2 class="h4 mb-3 mt-5">Галерея</h2>

<div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
  @forelse($photos as $p)
    <div class="col">
      <div class="card h-100 shadow-sm">
        <img src="{{ Storage::url($p->image_path) }}"
             alt="{{ $p->title ?? '' }}"
             class="card-img-top"
             style="object-fit:cover; height:150px;">
        <div class="card-body p-2">
          <div class="small text-muted">{{ $p->title ?? '—' }}</div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-muted text-center border p-3 rounded">
      Поки що немає фото
    </div>
  @endforelse
</div>

@auth
<a class="btn btn-secondary mt-2"
   href="{{ route('ateliers.photos.index', ['atelier' => $slug]) }}">
    Управління фото
</a>
@endauth

<h2 class="h4 mt-5 mb-3">Відгуки</h2>

@auth
    <form method="post"
          action="{{ route('ateliers.comments.store', ['atelier' => $slug]) }}"
          class="p-4 mb-4 border rounded bg-light">
        @csrf
        <div class="d-flex align-items-center mb-3">
            <label for="rating-select" class="form-label me-3 mb-0">Оцінка:</label>
            <select name="rating" id="rating-select" class="form-select form-select-sm" style="width: auto;">
                <option value="">—</option>
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}" @selected(old('rating')==$i)>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="mb-3">
            <textarea name="body" rows="4" class="form-control" placeholder="Ваш відгук..." required>{{ old('body') }}</textarea>
            @error('body') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-2">Надіслати</button>
    </form>
@else
    <p class="alert alert-info">
        <a href="{{ route('login') }}" class="alert-link">Увійдіть</a>, щоб залишити свій відгук.
    </p>
@endauth

<div class="divide-y border-top">
    @php
        $comments = $realAtelier
            ? $realAtelier->comments()->latest()->get()
            : collect();
    @endphp

    @forelse($comments as $c)
        <div class="py-3">
            <div class="d-flex justify-content-between align-items-center small text-muted">
                <span class="fw-bold text-dark">{{ $c->user->name ?? 'Гість' }}</span>
                <div>
                    @if($c->rating)
                        <span class="text-warning fw-bold">★ {{ $c->rating }}</span>
                        <span class="text-secondary">•</span>
                    @endif
                    <span>{{ $c->created_at->diffForHumans() }}</span>

                    <form method="POST"
                          action="{{ route('ateliers.comments.destroy', ['atelier' => $slug, 'comment' => $c]) }}"
                          class="d-inline ms-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm btn-link text-danger p-0"
                                onclick="return confirm('Ви впевнені, що хочете видалити цей коментар?')">
                            Видалити
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-dark mt-1">{{ $c->body }}</div>
        </div>
    @empty
        <div class="text-muted py-4 border-top text-center">Ще немає відгуків</div>
    @endforelse
</div>

</div>
@endsection