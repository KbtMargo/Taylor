@extends('layouts.app')

@section('title','Каталог матеріалів')

@section('content')
<h1 style="text-align:center; margin-bottom:30px;">Каталог матеріалів</h1>

<div style="
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    max-width: 1300px;
    margin: 0 auto;
">
    @foreach($materials as $material)
        <div style="
            background:#f9f9f9;
            border-radius:10px;
            box-shadow:0 2px 6px rgba(0,0,0,0.1);
            padding:15px;
            display:flex;
            flex-direction:column;
        ">
            <!-- Фото -->
            <img src="{{ $material['image'] }}" alt="{{ $material['name'] }}" style="width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:10px;">

            <!-- Інформація -->
            <h3 style="margin:5px 0;">{{ $material['name'] }}</h3>
            <p style="margin:3px 0;">{{ $material['colors'] }}</p>
            <p style="margin:3px 0;">{{ $material['delivery'] }}</p>

            <!-- Ціна та наявність в одному рядку -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:auto;">
                <span style="color:#007bff; font-weight:bold;">
                    {{ $material['price'] }}
                </span>
                <span style="
                    display:inline-block;
                    padding:4px 8px;
                    border-radius:5px;
                    background-color: {{ $material['in_stock'] ? '#d4edda' : '#f8d7da' }};
                    color: {{ $material['in_stock'] ? '#155724' : '#721c24' }};
                    font-weight:bold;
                ">
                    {{ $material['in_stock'] ? 'В наявності' : 'Немає в наявності' }}
                </span>
            </div>
        </div>
    @endforeach
</div>

<!-- Адаптивність для менших екранів -->
<style>
@media (max-width: 1000px) {
    div[style*="grid-template-columns: repeat(3"] {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 700px) {
    div[style*="grid-template-columns: repeat(3"] {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
