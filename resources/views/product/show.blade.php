@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-5">
    <div class="row">
        {{-- Колонка з зображенням --}}
        <div class="col-md-6 mb-4">
            <div class="card border-0">
                <img src="{{ asset($product->first_image_url) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
            </div>
        </div>

        {{-- Колонка з інформацією та формою замовлення --}}
        <div class="col-md-6">
            {{-- Назва товару --}}
            <h1>{{ $product->name }}</h1>

            {{-- Ціна та наявність --}}
            <div class="d-flex align-items-center my-3">
                <span class="price h3 me-4">{{ $product->price_per_m }} грн/м</span>
                @if($product->stock_m > 0)
                    <span class="badge bg-success fs-6">В наявності</span>
                @else
                    <span class="badge bg-danger fs-6">Немає в наявності</span>
                @endif
            </div>

            {{-- Опис --}}
            <p class="text-muted">{{ $product->description }}</p>

            {{-- Характеристики --}}
            <div class="my-4">
                <h5 class="mb-3">Характеристики:</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between"><span>Матеріал:</span> <strong>{{ $product->material ?? 'Не вказано' }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Колір:</span> <strong>{{ $product->color ?? 'Не вказано' }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Ширина:</span> <strong>{{ $product->width_cm ? $product->width_cm . ' см' : 'Не вказано' }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Артикул:</span> <strong>{{ $product->sku ?? 'Не вказано' }}</strong></li>
                </ul>
            </div>

            {{-- Форма замовлення --}}
            @if($product->stock_m > 0)
            <div class="card shadow-sm p-4">
                <h4 class="mb-3">Оформити замовлення</h4>
                <form action="{{ route('orders.store') }}" method="POST" id="order-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Кількість (метрів):</label>
                        <input type="number" class="form-control" id="quantity" name="quantity_m" value="1" min="0.1" step="0.1" required>
                    </div>

                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Ваше ім'я:</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Телефон:</label>
                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="h5">Загальна вартість: <span id="total-price" class="text-primary fw-bold">0.00 грн</span></div>
                        <button type="submit" class="btn btn-primary btn-lg">Замовити</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .price { color: #0d6efd; }
</style>

<script>
    // Скрипт для динамічного розрахунку вартості
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInput = document.getElementById('quantity');
        const totalPriceEl = document.getElementById('total-price');
        const pricePerMeter = {{ $product->price_per_m }};

        function calculateTotal() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const total = (quantity * pricePerMeter).toFixed(2);
            totalPriceEl.textContent = total + ' грн';
        }

        // Розрахувати при завантаженні сторінки
        calculateTotal();

        // Розраховувати при зміні кількості
        quantityInput.addEventListener('input', calculateTotal);
    });
</script>
@endsection

