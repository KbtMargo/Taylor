@extends('layouts.app')
@section('title', 'Фото — '.$atelier->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Фото: {{ $atelier->name }}</h4>
  <a href="{{ route('ateliers.photos.create', $atelier) }}" class="btn btn-primary">Додати фото</a>
</div>

@if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

@if($photos->count())
  <div class="row g-3">
    @foreach($photos as $p)
      <div class="col-6 col-md-3">
        <a href="{{ route('ateliers.photos.edit', [$atelier, $p]) }}" class="text-decoration-none">
          <img src="{{ $p->image_path }}" class="img-fluid rounded mb-1" alt="{{ $p->title }}">
          <div class="small text-muted">
            {{ $p->title ?? 'Без назви' }} • {{ $p->status }}
          </div>
        </a>
      </div>
    @endforeach
  </div>
  <div class="mt-3">{{ $photos->links() }}</div>
@else
  <div class="text-muted">Поки що немає фото</div>
@endif
@endsection
