@extends('layouts.app')

@section('title', $atelier['name'].' | Ательє')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:20px;">
    <a href="{{ route('page.atelier') }}" style="display:inline-flex; align-items:center; gap:6px; text-decoration:none; color:#2563eb; margin-bottom:15px;">
        ← Повернутися до списку
    </a>

    <div style="display:flex; gap:20px; align-items:flex-start; background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:20px;">
        <img src="{{ $atelier['image'] }}" alt="{{ $atelier['name'] }}" style="width:260px; height:260px; object-fit:cover; border-radius:10px;">
        <div style="flex:1;">
            <h1 style="margin:0 0 10px 0;">{{ $atelier['name'] }}</h1>

            <div style="display:grid; grid-template-columns:160px 1fr; gap:6px 16px; margin-bottom:12px;">
                <div><strong>Адреса:</strong></div>
                <div>{{ $atelier['address'] }}</div>

                <div><strong>Email:</strong></div>
                <div><a href="mailto:{{ $atelier['email'] }}">{{ $atelier['email'] }}</a></div>

                <div><strong>Телефон:</strong></div>
                <div><a href="tel:{{ preg_replace('/\s+/', '', $atelier['phone']) }}">{{ $atelier['phone'] }}</a></div>
            </div>

            @if(!empty($atelier['work_hours']))
                <div style="margin:10px 0 14px 0;">
                    <strong>Години роботи:</strong>
                    <ul style="margin:6px 0 0 0; padding-left:16px;">
                        @foreach($atelier['work_hours'] as $day => $hours)
                            <li>{{ $day }} — {{ $hours }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($atelier['tags']))
                <div style="margin:10px 0;">
                    <strong>Теги:</strong>
                    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:6px;">
                        @foreach($atelier['tags'] as $key => $values)
                            @foreach($values as $value)
                                <span style="background:#007bff; color:#fff; padding:4px 10px; border-radius:16px; font-size:0.85rem;">
                                    {{ $value }}
                                </span>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if(!empty($atelier['about']))
        <div style="margin-top:20px; background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:20px;">
            <h2 style="margin-top:0;">Про ательє</h2>
            <p style="margin:0;">{{ $atelier['about'] }}</p>
        </div>
    @endif

    @if(!empty($atelier['gallery']))
        <div style="margin-top:20px; background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:20px;">
            <h2 style="margin-top:0;">Галерея</h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:12px; margin-top:10px;">
                @foreach($atelier['gallery'] as $img)
                    <img src="{{ $img }}" alt="gallery" style="width:100%; height:180px; object-fit:cover; border-radius:8px;">
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
 