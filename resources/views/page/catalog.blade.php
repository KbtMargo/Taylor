@extends('layouts.app')

@section('title', 'Каталог матеріалів')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Каталог матеріалів</h1>

    @if($products->isEmpty())
        <p class="text-center">Наразі в каталозі немає товарів.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm product-card">
                        <a href="{{ route('products.show', $product) }}">
                            {{-- --- ОСНОВНА ЗМІНА ТУТ --- --}}
                            <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text small text-muted">{{ $product->description }}</p>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="price">{{ $product->price_per_m }} грн/м</span>
                                @if($product->stock_m > 0)
                                    <span class="badge bg-success">В наявності</span>
                                @else
                                    <span class="badge bg-danger">Немає в наявності</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .product-card { border-radius: 10px; transition: all 0.2s ease-in-out; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important; }
    .product-card .card-img-top { height: 200px; object-fit: cover; }
    .product-card .price { font-size: 1.1rem; font-weight: bold; color: #0d6efd; }
</style>
@endsection