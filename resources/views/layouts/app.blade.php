<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','App')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body class="page-container">
<header class="header container-padding">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        
        <a href="{{ route('page.index') }}" 
          style="border: none;">
            <span style="color: #314eb4; font-size: 1.75rem;"> 
                <strong>DressCode</strong>
            </span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('page.index') ? 'active' : '' }}" href="{{ route('page.index') }}">Головна</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('page.atelier') ? 'active' : '' }}" href="{{ route('page.atelier') }}">Ательє</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('page.catalog') ? 'active' : '' }}" href="{{ route(name: 'page.catalog') }}">Каталог матеріалів</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('page.about') ? 'active' : '' }}" href="{{ route('page.about') }}">Про нас</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('page.faq') ? 'active' : '' }}" href="{{ route(name: 'page.faq') }}">Контакти</a></li>
          </ul>

          <ul class="navbar-nav d-flex">
            @auth
              <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Профіль</a></li>
              <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="btn btn-outline-danger btn-sm" type="submit">Вийти</button>
                </form>
              </li>
            @else
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Увійти</a></li>
              <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('register') }}">Зареєструватися</a></li>
            @endauth
          </ul>
        </div>
      </div>
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