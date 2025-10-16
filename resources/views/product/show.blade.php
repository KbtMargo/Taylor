@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Виникла помилка!</strong> Будь ласка, перевірте правильність заповнення форми.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0">
                <img src="{{ asset($product->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
            </div>
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <div class="d-flex align-items-center my-3">
                <span class="price h3 me-4">{{ $product->price_per_m }} грн/м</span>
                
                {{-- --- ОСНОВНА ЗМІНА ТУТ --- --}}
                @if($product->stock_m > 0)
                    <span class="badge bg-success fs-6 me-2">В наявності</span>
                    <span class="text-muted small">Залишилось: {{ $product->stock_m }} м</span>
                @else
                    <span class="badge bg-danger fs-6">Немає в наявності</span>
                @endif
            </div>
            <p class="text-muted">{{ $product->description }}</p>
            <div class="my-4">
                <h5 class="mb-3">Характеристики:</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between"><span>Матеріал:</span> <strong>{{ $product->material ?? 'Не вказано' }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Колір:</span> <strong>{{ $product->color ?? 'Не вказано' }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Ширина:</span> <strong>{{ $product->width_cm ? $product->width_cm . ' см' : 'Не вказано' }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Артикул:</span> <strong>{{ $product->sku ?? 'Не вказано' }}</strong></li>
                </ul>
            </div>
            @if($product->stock_m > 0)
                <div class="d-grid gap-2 mt-4">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#orderModal">
                        Оформити замовлення
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@if($product->stock_m > 0)
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('orders.store') }}" method="POST" id="order-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Замовлення: {{ $product->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="text-muted">Контактна інформація</h6>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Ваше ім'я:</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Телефон:</label>
                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                    </div>
                    <hr>
                    <h6 class="text-muted">Деталі замовлення</h6>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Кількість (метрів):</label>
                        {{-- --- І ЩЕ ОДНА ЗМІНА ТУТ (додано max) --- --}}
                        <input type="number" class="form-control" id="quantity" name="quantity_m" value="{{ old('quantity_m', 1) }}" min="0.1" step="0.1" max="{{ $product->stock_m }}" required>
                    </div>
                     <div class="mb-3">
                        <label for="delivery_service" class="form-label">Спосіб доставки:</label>
                        <select class="form-select" id="delivery_service" name="delivery_service">
                            <option value="Нова Пошта" @if(old('delivery_service') == 'Нова Пошта') selected @endif>Нова Пошта</option>
                            <option value="Укрпошта" @if(old('delivery_service') == 'Укрпошта') selected @endif>Укрпошта</option>
                            <option value="Самовивіз" @if(old('delivery_service') == 'Самовивіз') selected @endif>Самовивіз</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="delivery_address" class="form-label">Місто та номер відділення/поштомату:</label>
                        <input type="text" class="form-control" id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}" placeholder="Напр: м. Київ, відділення №25">
                    </div>
                     <div class="mb-3">
                        <label for="customer_comment" class="form-label">Коментар до замовлення (необов'язково):</label>
                        <textarea class="form-control" id="customer_comment" name="customer_comment" rows="2">{{ old('customer_comment') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="h5 mb-0">Загальна вартість: <span id="total-price" class="text-primary fw-bold">0.00 грн</span></div>
                    <button type="submit" class="btn btn-primary">Підтвердити замовлення</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style> .price { color: #0d6efd; } </style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderModal = document.getElementById('orderModal');
        if (orderModal) {
            const quantityInput = orderModal.querySelector('#quantity');
            const totalPriceEl = orderModal.querySelector('#total-price');
            const pricePerMeter = {{ $product->price_per_m }};
            function calculateTotal() {
                const quantity = parseFloat(quantityInput.value) || 0;
                const total = (quantity * pricePerMeter).toFixed(2);
                totalPriceEl.textContent = total + ' грн';
            }
            quantityInput.addEventListener('input', calculateTotal);
            orderModal.addEventListener('show.bs.modal', calculateTotal);
        }
    });
</script>
@endsection
