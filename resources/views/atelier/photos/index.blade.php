@extends('layouts.app')

@section('title', ($atelier->name ?? 'Ательє').' — Фото')

@section('content')
<div class="container py-4">
    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    {{-- Посилання на публічну сторінку ательє --}}
    <a href="{{ route('page.atelier.show', ['slug'=>$atelier->slug]) }}"
       class="text-primary text-decoration-none mb-3 d-inline-block">← Назад до ательє</a>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 m-0">Управління фотографіями: {{ $atelier->name }}</h1>

        {{-- Кнопка "Додати фото" --}}
        @auth
            <a href="{{ route('ateliers.photos.create', $atelier) }}" class="btn btn-sm btn-primary">
                + Додати фото
            </a>
        @endauth
    </div>

    @if($photos->isEmpty())
        <div class="text-muted border rounded p-4 text-center">Поки що немає фотографій</div>
    @else
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($photos as $p)
                <div class="col">
                    {{-- 
                        КЛЮЧОВА ЗМІНА: 
                        Весь блок робимо посиланням на форму редагування.
                        Використовуємо маршрут 'ateliers.photos.edit' з двома параметрами.
                    --}}
                    <a href="{{ route('ateliers.photos.edit', [$atelier, $p]) }}" 
                       class="d-block text-decoration-none card h-100 shadow-sm">
                        
                        {{-- Зображення --}}
                        {{-- Примітка: використовуйте $p->image_path або $p->url. Я залишив $p->url як у вашому прикладі. --}}
                        <img src="{{ $p->url }}" alt="{{ $p->title }}"
                             class="card-img-top" style="object-fit:cover; height:180px;">
                        
                        <div class="card-body p-2 small">
                            <div class="text-dark fw-bold text-truncate">{{ $p->title ?? 'Без заголовка' }}</div>
                            <div class="text-muted mt-1">
                                Статус: 
                                <span class="badge bg-{{ $p->status === 'published' ? 'success' : 'warning' }}">
                                    {{ $p->status === 'published' ? 'Опубліковано' : 'Чернетка' }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        {{-- Пагінація --}}
        <div class="mt-3">
            {{ $photos->links() }}
        </div>
    @endif
</div>
@endsection