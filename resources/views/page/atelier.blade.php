@extends('layouts.app')

@section('title','Ательє | DressCode Website')

@section('content')
<h1 style="text-align:center; margin-bottom:30px;">Наші ательє</h1>

<!-- Поле пошуку -->
<form method="GET" action="{{ route('page.atelier') }}" style="display:flex; justify-content:center; align-items:center; margin-bottom:30px; gap:10px;">
    <input type="text" name="search" placeholder="Введіть назву ательє або тег..."
           value="{{ $search ?? '' }}" style="padding:5px 10px; width:400px; flex-shrink:0;">
    <button type="submit" style="padding:5px 15px; width:auto; flex-shrink:0; cursor:pointer;">Пошук</button>
</form>

<!-- Відображення ательє -->
@if(count($ateliers) > 0)
<div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
    @foreach($ateliers as $atelier)
        <div style="display: flex; align-items: flex-start; width: 1300px; background: #ffffff; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 15px;">
            <img src="{{ $atelier['image'] }}" alt="{{ $atelier['name'] }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
            <div style="flex: 1;">
                <h2 style="margin: 0 0 5px 0;">{{ $atelier['name'] }}</h2>
                <p style="margin:2px 0;"><strong>Адреса:</strong> {{ $atelier['address'] }}</p>
                <p style="margin:2px 0;"><strong>Email:</strong> {{ $atelier['email'] }}</p>
                <p style="margin:2px 0;"><strong>Телефон:</strong> {{ $atelier['phone'] }}</p>
                <p style="margin:5px 0 2px 0;"><strong>Теги:</strong></p>
                <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                    @foreach($atelier['tags'] as $key => $values)
                        @foreach($values as $value)
                            <span style="background:#007bff; color:#fff; padding:3px 8px; border-radius:5px; font-size:0.85rem;">
                                {{ $value }}
                            </span>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
<p style="text-align:center; font-size:1.2rem; margin-top:20px;">Ательє за вашим запитом не знайдено.</p>
@endif

@endsection
