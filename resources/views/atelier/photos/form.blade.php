@extends('layouts.app')

@section('title', ($photo->exists ? 'Редагувати' : 'Додати').' фото — '.$atelier->name)

@section('content')
<div class="container py-4">
    <a href="{{ route('ateliers.photos.index', $atelier) }}" class="text-primary text-decoration-none mb-3 d-inline-block">
        ← До списку фото
    </a>

    <h1 class="h4 mb-3">{{ $photo->exists ? 'Редагувати' : 'Додати' }} фото: {{ $atelier->name }}</h1>

    @if(session('ok')) 
        <div class="alert alert-success">{{ session('ok') }}</div> 
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold">Помилки у формі:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" enctype="multipart/form-data" class="card p-4"
          action="{{ $photo->exists 
              ? route('ateliers.photos.update', [$atelier, $photo]) 
              : route('ateliers.photos.store', $atelier) }}">
        
        @csrf
        @if($photo->exists) 
            @method('PUT') 
        @endif

        <div class="mb-3">
            <label class="form-label">Зображення (залиште порожнім, щоб не змінювати)</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" {{ $photo->exists ? '' : 'required' }}>
            
            @if($photo->image_path)
                <img src="{{ $photo->image_path }}" class="img-fluid rounded mt-2" alt="Поточне зображення" style="max-height:200px">
            @endif
            
            @error('image') 
                <div class="text-danger small">{{ $message }}</div> 
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Заголовок</label>
            <input name="title" value="{{ old('title', $photo->title) }}" class="form-control @error('title') is-invalid @enderror">
            @error('title') 
                <div class="text-danger small">{{ $message }}</div> 
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Опис</label>
            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $photo->description) }}</textarea>
            @error('description') 
                <div class="text-danger small">{{ $message }}</div> 
            @enderror
        </div>

        <div class="row g-3">
            <div class="col-sm-4">
                <label class="form-label">Статус</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    @php($currentStatus = old('status', $photo->exists ? $photo->status : 'draft'))
                    <option value="draft" {{ $currentStatus == 'draft' ? 'selected' : '' }}>Чернетка</option>
                    <option value="published" {{ $currentStatus == 'published' ? 'selected' : '' }}>Опубліковано</option>
                </select>
            </div>
            
            <div class="col-sm-4">
                <label class="form-label">Дата публікації</label>
                <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror"
                       value="{{ old('published_at', optional($photo->published_at)->format('Y-m-d\TH:i')) }}">
            </div>
            
            <div class="col-sm-4">
                <label class="form-label">Порядок</label>
                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                       value="{{ old('sort_order', $photo->sort_order) }}">
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Зберегти</button>
            <a class="btn btn-outline-secondary" href="{{ route('ateliers.photos.index', $atelier) }}">До списку</a>

            @if($photo->exists)
                <button type="button" class="btn btn-danger" 
                        onclick="document.getElementById('delete-photo-form').submit();">
                    Видалити
                </button>
            @endif
        </div>
    </form>
    
    @if($photo->exists)
        <form id="delete-photo-form" method="post" 
              action="{{ route('ateliers.photos.destroy', [$atelier, $photo]) }}"
              onsubmit="return confirm('Ви впевнені, що хочете видалити це фото?');" 
              style="display: none;">
            @csrf 
            @method('DELETE')
        </form>
    @endif
</div>
@endsection