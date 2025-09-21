@extends('layouts.app')

@section('title','Результати підбору | DressCode Website')

@section('content')
<h1 style="text-align:center; margin-bottom:30px;">Результати підбору ательє</h1>

@if(count($ateliers) > 0)
    <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
        @foreach($ateliers as $atelier)
            <div style="display: flex; align-items: flex-start; width: 1300px; background: #ffffff; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 15px;">

                <!-- Фото ательє -->
                <img src="{{ $atelier['image'] }}" alt="{{ $atelier['name'] }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; margin-right: 15px;">

                <!-- Інформація ательє -->
                <div style="flex: 1;">
                    <h2 style="margin: 0 0 5px 0;">{{ $atelier['name'] }}</h2>

                    <div class="atelier-info">
                        <p style="margin:2px 0;"><strong>Адреса:</strong> {{ $atelier['address'] }}</p>
                        <p style="margin:2px 0;"><strong>Email:</strong> {{ $atelier['email'] }}</p>
                        <p style="margin:2px 0;"><strong>Телефон:</strong> {{ $atelier['phone'] }}</p>
                        <p style="margin:5px 0 2px 0;"><strong>Теги:</strong></p>

                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                            @foreach($atelier['tags'] as $key => $values)
                                @if(is_array($values))
                                    @foreach($values as $value)
                                        <span style="background:#007bff; color:#fff; padding:3px 8px; border-radius:5px; font-size:0.85rem;">
                                            {{ $value }}
                                        </span>
                                    @endforeach
                                @else
                                    <span style="background:#007bff; color:#fff; padding:3px 8px; border-radius:5px; font-size:0.85rem;">
                                        {{ $values }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p style="text-align:center; font-size:1.2rem; color:#555;">На жаль, ательє за вашими критеріями не знайдено.</p>
@endif
@endsection
