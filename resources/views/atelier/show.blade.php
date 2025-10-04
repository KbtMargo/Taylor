@extends('layouts.app')

@section('title', $atelier['name'].' | Ательє')

@section('content')
<div class="container py-4">
    <a href="{{ route('page.atelier') }}" class="text-primary text-decoration-none mb-4 d-inline-block">
        ← Повернутися до списку
    </a>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-4 align-items-start">
                
                <div class="col-md-4 col-lg-3">
                    <img src="{{ $atelier['image'] }}" alt="{{ $atelier['name'] }}" class="img-fluid rounded" style="object-fit:cover; height:250px; width:100%;">
                </div>
                
                <div class="col-md-8 col-lg-9">
                    <h1 class="h3 mb-3">{{ $atelier['name'] }}</h1>

                    <dl class="row mb-4 border-bottom pb-3">
                        <dt class="col-sm-3 fw-bold text-muted">Адреса:</dt>
                        <dd class="col-sm-9">{{ $atelier['address'] }}</dd>

                        <dt class="col-sm-3 fw-bold text-muted">Email:</dt>
                        <dd class="col-sm-9"><a href="mailto:{{ $atelier['email'] }}" class="text-primary">{{ $atelier['email'] }}</a></dd>

                        <dt class="col-sm-3 fw-bold text-muted">Телефон:</dt>
                        <dd class="col-sm-9"><a href="tel:{{ preg_replace('/\s+/', '', $atelier['phone']) }}" class="text-primary">{{ $atelier['phone'] }}</a></dd>
                    </dl>

                    @if(!empty($atelier['work_hours']))
                        <div class="mb-3">
                            <strong class="text-muted">Години роботи:</strong>
                            <ul class="mt-1 ps-4 text-secondary">
                                @foreach($atelier['work_hours'] as $day => $hours)
                                    <li>{{ $day }} — {{ $hours }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!empty($atelier['tags']))
                        <div class="mt-3">
                            <strong class="text-muted">Теги:</strong>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @foreach($atelier['tags'] as $key => $values)
                                    @foreach($values as $value)
                                        <span class="badge bg-primary rounded-pill shadow-sm">
                                            {{ $value }}
                                        </span>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(!empty($atelier['about']))
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Про ательє</h2>
                <p class="text-secondary">{{ $atelier['about'] }}</p>
            </div>
        </div>
    @endif

    @if(!empty($atelier['gallery']) || $atelier->photos()->published()->count() > 0)
        
        <h2 class="h4 mb-3 mt-5">Галерея</h2>
        <div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
        @forelse($atelier->photos()->published()->orderBy('sort_order')->latest('id')->take(12)->get() as $p)
            <div class="col">
                    <a href="{{ route('ateliers.photos.index', $atelier) }}">
                    <img src="{{ $p->image_path }}" alt="{{ $p->title }}" class="img-fluid rounded" style="object-fit:cover; height:150px; width:100%;"/>
                    <div class="text-muted small mt-1">{{ $p->title }}</div>
                </a>
            </div>
        @empty
            <div class="col-12 text-muted text-center border p-3 rounded">Поки що немає фото</div>
        @endforelse
        </div>
        
        <a class="btn btn-secondary mt-2" href="{{ route('ateliers.photos.index', $atelier->slug) }}">Управління фото</a>
        
        <h2 class="h4 mt-5 mb-3">Відгуки</h2>
        
        @auth
        <form method="post" action="{{ route('ateliers.comments.store', $atelier->slug) }}" class="p-4 mb-4 border rounded bg-light">
          @csrf
          <div class="d-flex align-items-center mb-3">
            <label class="form-label me-3 mb-0">Оцінка:</label>
            <select name="rating" class="form-select form-select-sm" style="width: auto;">
              <option value="">—</option>
              @for($i=1;$i<=5;$i++) <option value="{{ $i }}">{{ $i }}</option> @endfor
            </select>
          </div>
          <div class="mb-3">
              <textarea name="body" rows="4" class="form-control" placeholder="Ваш відгук..." required></textarea>
          </div>
          <button class="btn btn-primary mt-2">Надіслати</button>
        </form>
        @endauth

        <div class="divide-y border-top">
        @forelse($atelier->comments()->latest()->get() as $c)
          <div class="py-3">
            <div class="d-flex justify-content-between align-items-center small text-muted">
              <span class="fw-bold text-dark">{{ $c->user->name ?? 'Гість' }}</span>
              <div>
                @if($c->rating) 
                    <span class="text-warning fw-bold">★ {{ $c->rating }}</span> 
                    <span class="text-secondary">•</span>
                @endif
                <span>{{ $c->created_at->diffForHumans() }}</span>
              </div>
            </div>
            <div class="text-dark mt-1">{{ $c->body }}</div>
          </div>
        @empty
          <div class="text-muted py-4 border-top text-center">Ще немає відгуків</div>
        @endforelse
        </div>
    @endif
</div>
@endsection