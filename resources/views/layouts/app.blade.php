<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','DressCode')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    #chat-toggle-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #007bff; 
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 9998;
    }
    #chat-toggle-button svg {
        width: 32px;
        height: 32px;
    }

    #chat-window {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 350px;
        height: 500px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        z-index: 9999;
    }

    #chat-header {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
    }
    #chat-close-button {
        cursor: pointer;
        font-size: 24px;
    }

    #chat-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        overflow-y: hidden;
    }

    #recipient-list {
        padding: 10px;
        overflow-y: auto;
    }
    #recipient-list ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .chat-recipient-item {
        padding: 12px 10px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        font-weight: 500;
    }
    .chat-recipient-item:hover {
        background-color: #f9f9f9;
    }

    #message-view {
        display: none; 
        flex-direction: column;
        height: 100%;
    }
    #message-header {
        padding: 10px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
    }
    #back-to-list {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        margin-right: 10px;
    }
    #chat-with-name {
        font-weight: bold;
    }
    #message-list {
        flex-grow: 1;
        padding: 10px;
        overflow-y: auto;
        background-color: #f9f9f9;
    }
    #message-input-area {
        display: flex;
        border-top: 1px solid #eee;
        padding: 10px;
    }
    #message-input {
        flex-grow: 1;
        border: 1px solid #ccc;
        border-radius: 20px;
        padding: 8px 12px;
    }
    #send-message-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0 10px;
    }
    #send-message-button svg {
        width: 24px;
        height: 24px;
        color: #007bff;
    }
  </style>
  </head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body class="page-container">
<header class="header container-padding">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a href="{{ route('home') }}" style="border: none;">
            <span style="color: #314eb4; font-size: 1.75rem;">
                <strong>DressCode</strong>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Головна</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('ateliers.index') ? 'active' : '' }}" href="{{ route('ateliers.index') }}">Ательє</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('page.catalog') ? 'active' : '' }}" href="{{ route('page.catalog') }}">Каталог матеріалів</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('page.about') ? 'active' : '' }}" href="{{ route('page.about') }}">Про нас</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('page.faq') ? 'active' : '' }}" href="{{ route('page.faq') }}">FAQ</a></li>
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

@auth  <div id="chat-toggle-button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25a9.76 9.76 0 01-2.53-.388 1.875 1.875 0 01-1.002-1.002A9.76 9.76 0 013 12c0-4.556 3.86-8.25 8.625-8.25a9.76 9.76 0 012.53.388 1.875 1.875 0 011.002 1.002A9.76 9.76 0 0121 12z" />
        </svg>
    </div>

    <div id="chat-window" style="display: none;">
        
        <div id="chat-header">
            <span>Чат користувачів</span>
            <span id="chat-close-button">&times;</span>
        </div>

        <div id="chat-body">
            
            <div id="recipient-list">
                <p>Виберіть, кому написати:</p>
                <ul>
                    @if(isset($chatRecipients) && $chatRecipients->count() > 0)
                        
                        @foreach($chatRecipients as $recipient)
                            <li class="chat-recipient-item" data-id="{{ $recipient->id }}">
                                {{ $recipient->name }} 
                                </li>
                        @endforeach

                    @else
                        <li>Немає користувачів для чату.</li>
                    @endif
                </ul>
            </div>

            <div id="message-view" style="display: none;">
                <div id="message-header">
                    <button id="back-to-list">&larr;</button>
                    <span id="chat-with-name"></span>
                </div>
                <div id="message-list">
                    </div>
                <div id="message-input-area">
                    <input type="text" id="message-input" placeholder="Напишіть повідомлення...">
                    <button id="send-message-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.875L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
@endauth
<script>
document.addEventListener('DOMContentLoaded', (event) => {

    const toggleButton = document.getElementById('chat-toggle-button');
    const chatWindow = document.getElementById('chat-window');
    const closeButton = document.getElementById('chat-close-button');
    
    const recipientListScreen = document.getElementById('recipient-list');
    const messageViewScreen = document.getElementById('message-view');
    const backButton = document.getElementById('back-to-list');
    const recipientItems = document.querySelectorAll('.chat-recipient-item');
    const chatWithName = document.getElementById('chat-with-name');

    if (toggleButton) {
        
        toggleButton.addEventListener('click', () => {
            chatWindow.style.display = 'flex'; 
            toggleButton.style.display = 'none'; 
        });

        closeButton.addEventListener('click', () => {
            chatWindow.style.display = 'none';
            toggleButton.style.display = 'flex'; 
        });

        recipientItems.forEach(item => {
            item.addEventListener('click', () => {
                const recipientName = item.innerText;
                const recipientId = item.dataset.id;

                chatWithName.innerText = `Чат з ${recipientName}`;
                
                // (В майбутньому тут буде завантаження історії повідомлень)
                // loadMessages(recipientId); 

                recipientListScreen.style.display = 'none';
                messageViewScreen.style.display = 'flex'; 
            });
        });

        backButton.addEventListener('click', () => {
            messageViewScreen.style.display = 'none';
            recipientListScreen.style.display = 'block';
        });
    }

});
</script>
</body>
</html>