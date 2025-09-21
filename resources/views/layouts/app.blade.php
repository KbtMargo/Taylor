<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','App')</title>

  <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@2/css/pico.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body class="container">

  <nav style="margin-top:1rem">
    <ul>
      <li><strong>DressCode</strong></li>
    </ul>
    <ul>
      <li><a href="{{ route('page.index') }}">Головна</a></li>
      <li><a href="{{ route('page.atelier') }}">Ательє</a></li>
      <li><a href="{{ route('page.about') }}">Про нас</a></li>
      <li><a href="{{ route('page.faq') }}">FAQ</a></li>
    </ul>
  </nav>

  <main style="margin-top:1rem">
    @yield('content')
  </main>

</body>
</html>
