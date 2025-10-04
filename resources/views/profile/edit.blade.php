@extends('layouts.app')

@section('title','Профіль')

@section('content')
  <h2 class="h4 mb-3">Профіль</h2>

  @if (session('status') === 'profile-updated')
    <div class="alert alert-success">Збережено</div>
  @endif

  <div class="mb-4 p-3 bg-white shadow-sm rounded">
    @include('profile.partials.update-profile-information-form')
  </div>

  <div class="mb-4 p-3 bg-white shadow-sm rounded">
    @include('profile.partials.update-password-form')
  </div>

  <div class="mb-4 p-3 bg-white shadow-sm rounded">
    @include('profile.partials.delete-user-form')
  </div>
@endsection
