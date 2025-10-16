@extends('layouts.app')

@section('title', 'Наші Ательє')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Наші Ательє</h1>
        <a href="{{ route('page.select') }}" class="btn btn-primary">Підібрати ательє за параметрами</a>
    </div>

    @if($ateliers->isEmpty())
        <div class="text-center">
            <p>Наразі ательє не знайдено.</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($ateliers as $atelier)
                <div class="col">
                    <div class="card h-100 shadow-sm atelier-card">
                        <img src="{{ asset($atelier->image ?? '/images/default_atelier.jpg') }}" class="card-img-top" alt="{{ $atelier->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $atelier->name }}</h5>
                            <p class="card-text small text-muted">
                                <i class="bi bi-geo-alt-fill me-1"></i>
                                {{ $atelier->city }}, {{ $atelier->address }}
                            </p>
                            <div class="mt-auto">
                                {{-- Використовуємо правильне ім'я маршруту 'ateliers.show' --}}
                                <a href="{{ route('ateliers.show', $atelier) }}" class="btn btn-outline-primary w-100">Детальніше</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Пагінація, якщо вона є --}}
        <div class="mt-4">
            {{ $ateliers->links() }}
        </div>
    @endif
</div>

{{-- Додамо трохи стилів для кращого вигляду --}}
<style>
    .atelier-card {
        border-radius: 10px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .atelier-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px Bpx rgba(0,0,0,0.1);
    }
    .atelier-card .card-img-top {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
