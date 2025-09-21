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

<body class="page-container">
<header class="header container-padding">
    <nav>
      <ul>
        <li><span style="color: #1b3db7; font-size: 1.75rem;"> <strong>DressCode</strong></span></li>

      </ul>
      <ul>
        <li><a href="{{ route('page.index') }}" class="{{ request()->routeIs('page.index') ? 'active' : '' }}">Головна</a></li>
        <li><a href="{{ route('page.atelier') }}" class="{{ request()->routeIs('page.atelier') ? 'active' : '' }}">Ательє</a></li>
        <li><a href="{{ route(name: 'page.catalog') }}" class="{{ request()->routeIs('page.catalog') ? 'active' : '' }}">Каталог матеріалів</a></li>
        <li><a href="{{ route('page.about') }}" class="{{ request()->routeIs('page.about') ? 'active' : '' }}">Про нас</a></li>
        <li><a href="{{ route(name: 'page.faq') }}" class="{{ request()->routeIs('page.faq') ? 'active' : '' }}">Контакти</a></li>
      </ul>
    </nav>
  </header>

  <main class="main-content container-padding">
    @yield('content')
  </main>

  <footer class="footer container-padding">
    &copy; {{ date('Y') }} DressCode. Всі права захищені.
  </footer>

</body>
</html>
