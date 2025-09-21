@extends('layouts.app')

@section('title','Головна | DressCode Website')

@section('content')
<div class="home-content">
<h1>  Знайди свого майстра. <span style="color: #1b3db7;">Створи свій стиль.</span></span></h1>
    <p>Платформа, що з'єднує клієнтів із професійними майстрами та ательє, дозволяючи створювати унікальний одяг та аксесуари вашої мрії. Ми допомагаємо реалізувати індивідуальні замовлення швидко, зручно та на найвищому рівні якості.</p>

    <a href="{{ route('page.match') }}" class="btn-filled">Розпочати</a>
    <a href="{{ route('page.catalog') }}" class="btn-outline">Переглянути матеріали</a>

    <style>
/* Перша кнопка: прозора */
        .btn-outline {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #1b3db7;
            border: 2px solid #1b3db7;
            background-color: transparent;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-outline:hover {
            background-color: #1b3db7;
            color: white;
        }

        /* Друга кнопка: залита */
        .btn-filled {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            border: 2px solid #1b3db7;
            background-color: #1b3db7;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-filled:hover {
            background-color: transparent;
            color: #1b3db7;
        }
</style>
</div>
@endsection
