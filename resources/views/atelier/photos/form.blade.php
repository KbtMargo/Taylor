@extends('layouts.app')
@section('title', ($photo->exists?'Редагувати':'Додати').' фото — '.$atelier->name)

@section('content')
<h4 class="mb-3">{{ $photo->exists ? 'Редагувати' : 'Додати' }} фото — {{ $atelier->name }}</h4>

@if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

<form method="post" enctype="multipart/form-data"
      action="{{ $photo->exists ? route('ateliers.photos.update',[$atelier,$photo]) : route('ateliers.photos.store',$atelier) }}">
  @csrf
  @if($photo->exists) @method('PUT') @endif

  <div class="mb-3">
    <label class="form-label">Зображення</label>
    <input type="file" name="image" class="form-control" {{ $photo->exists ? '' : 'required' }}>
    @if($photo->image_path)
      <img src="{{ $photo->image_path }}" class="img-fluid rounded mt-2" style="max-height:200px">
    @endif
    @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Заголовок</label>
    <input name="title" value="{{ old('title',$photo->title) }}" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Опис</label>
    <textarea name="description" rows="4" class="form-control">{{ old('description',$photo->description) }}</textarea>
  </div>

  <div class="row g-3">
    <div class="col-sm-4">
      <label class="form-label">Статус</label>
      <select name="status" class="form-select">
        <option value="draft" {{ old('status',$photo->status)=='draft'?'selected':'' }}>Чернетка</option>
        <option value="published" {{ old('status',$photo->status)=='published'?'selected':'' }}>Опубліковано</option>
      </select>
    </div>
    <div class="col-sm-4">
      <label class="form-label">Дата публікації</label>
      <input type="datetime-local" name="published_at" class="form-control"
             value="{{ old('published_at', optional($photo->published_at)->format('Y-m-d\TH:i')) }}">
    </div>
    <div class="col-sm-4">
      <label class="form-label">Порядок</label>
      <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$photo->sort_order) }}">
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <button class="btn btn-primary">Зберегти</button>
    <a class="btn btn-outline-secondary" href="{{ route('ateliers.photos.index',$atelier) }}">До списку</a>

    @if($photo->exists)
      <form method="post" action="{{ route('ateliers.photos.destroy',[$atelier,$photo]) }}"
            onsubmit="return confirm('Видалити фото?');" class="d-inline">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Видалити</button>
      </form>
    @endif
  </div>
</form>
@endsection
