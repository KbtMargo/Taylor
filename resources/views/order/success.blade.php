@extends('layouts.app')

@section('title', 'Замовлення прийнято')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">Дякуємо за ваше замовлення!</h1>
            <p class="lead">Ваше замовлення успішно оформлено. Наш менеджер зв'яжеться з вами найближчим часом для підтвердження деталей.</p>
            <a href="{{ route('page.catalog') }}" class="btn btn-primary mt-4">Повернутися до каталогу</a>
        </div>
    </div>
</div>
@endsection
