@extends('layouts.app')

@section('title','Підбір Ательє')

@section('content')
<div class="home-page-container" style="display: flex; flex-wrap: wrap; align-items: stretch; gap: 2rem; min-height: 70vh;">

    <!-- Ліва частина: текст і кнопки -->
    <div class="home-text" style="flex: 1; min-width: 300px; max-width: 600px; display: flex; flex-direction: column; justify-content: center;">
        <h1>Знайди ательє, що втілить твої <span style="color: #1b3db7;"> унікальні ідеї</span></h1>

        <p>
            Вибір правильного ательє — це перший крок до вашого ідеального образу.
            Наш сервіс допоможе вам підібрати ательє, яке найкраще відповідає вашим побажанням.
            Від класики до модного дизайну, від швидкого пошиву до індивідуальних замовлень — ми знаємо, як зробити ваш стиль унікальним.
        </p>

        <p>
            Просто оберіть характеристики, які вас цікавлять, і система підбере відповідне вашим потребам ательє.
        </p>

        <div style="display: flex; gap: 1.5rem; margin-top: 1.5rem; flex-wrap: wrap;">
            <a href="{{ route('page.select') }}" class="btn-filled">Підібрати Ательє</a>
            <a href="https://t.me/dresscode_helper_bot" target="_blank" class="btn-filled">
                Telegram Бот
            </a>
        </div>
    </div>

    <!-- Права частина: зображення ательє -->
    <div class="home-image" style="flex: 1; min-width: 300px; border-radius: 8px; overflow: hidden;">
        <img src="{{ asset('images/Atelier Colage.png') }}" alt="Ательє" style="width: 100%; height: 100%; object-fit: cover; min-height: 300px;">
    </div>

</div>

<style>
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

    /* Адаптивність для маленьких екранів */
    @media (max-width: 900px) {
        .home-page-container {
            flex-direction: column;
            align-items: center;
        }
        .home-text, .home-image {
            max-width: 100%;
        }
        .home-image img {
            min-height: 200px;
        }
    }
</style>
@endsection
