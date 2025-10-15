@extends('layouts.app')

@section('title', $atelier->name)

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-5">
            <img src="{{ asset($atelier->image ?? '/images/default_atelier.jpg') }}" alt="{{ $atelier->name }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-7">
            <h1 class="mb-3">{{ $atelier->name }}</h1>
            <p class="lead text-muted">
                <i class="bi bi-geo-alt-fill me-1"></i>
                {{ $atelier->city }}, {{ $atelier->address }}
            </p>
            <hr>
            
            <h5 class="mt-4">Контактна інформація:</h5>
            <ul class="list-unstyled">
                @if($atelier->phone)
                    <li><i class="bi bi-telephone-fill me-2"></i> {{ $atelier->phone }}</li>
                @endif
                @if($atelier->email)
                    <li><i class="bi bi-envelope-fill me-2"></i> {{ $atelier->email }}</li>
                @endif
            </ul>

            @if(!empty($atelier->tags))
                <h5 class="mt-4">Послуги та спеціалізація:</h5>
                <div class="d-flex flex-wrap">
                    @foreach($atelier->tags as $category => $tags)
                        @foreach($tags as $tag)
                            <span class="badge bg-secondary me-2 mb-2">{{ $tag }}</span>
                        @endforeach
                    @endforeach
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('ateliers.index') }}" class="btn btn-outline-primary">&larr; Повернутися до списку ательє</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection