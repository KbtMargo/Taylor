@extends('layouts.app')

@section('title','Ательє | DressCode Website')

@section('content')
<h1 class="text-3xl font-bold text-center mb-6">Наші ательє</h1>

<form method="GET" action="{{ route('page.atelier') }}" class="flex justify-center items-center mb-6 gap-3">
    <input type="text" name="search" placeholder="Введіть назву ательє або тег..."
           value="{{ $search ?? '' }}" class="p-2 border border-gray-300 rounded w-96 flex-shrink-0">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-150 cursor-pointer">
        Пошук
    </button>
</form>

@if(count($ateliers) > 0)
<div class="flex flex-col items-center space-y-5">
    @foreach($ateliers as $atelier)
        <a href="{{ route('page.atelier.show', $atelier['slug']) }}"
               class="block w-[1300px] no-underline text-inherit hover:shadow-lg transition duration-200">         
            <div class="flex items-start w-full bg-white rounded-xl shadow-md p-4">
                <img src="{{ $atelier['image'] }}" alt="{{ $atelier['name'] }}" class="w-32 h-32 object-cover rounded-lg mr-4 flex-shrink-0">
                
                <div class="flex-1">
                    <h2 class="text-xl font-semibold mb-1 text-blue-600">{{ $atelier['name'] }}</h2>
                    <p class="text-sm my-1"><strong>Адреса:</strong> {{ $atelier['address'] }}</p>
                    <p class="text-sm my-1"><strong>Email:</strong> {{ $atelier['email'] }}</p>
                    <p class="text-sm my-1"><strong>Телефон:</strong> {{ $atelier['phone'] }}</p>
                    <p class="text-sm mt-3 mb-1"><strong>Теги:</strong></p>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($atelier['tags'] as $key => $values)
                            @foreach($values as $value)
                                <span class="bg-indigo-500 text-white px-2 py-1 rounded text-xs">
                                    {{ $value }}
                                </span>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>
@else
<p class="text-center text-xl text-gray-600 mt-8">Ательє за вашим запитом не знайдено.</p>
@endif
@endsection