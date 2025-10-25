<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF-токен (ОБОВ'ЯЗКОВО ДЛЯ POST-ЗАПИТІВ ТА ECHO) -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>@yield('title','DressCode')</title>
  
  <!-- Ваш оригінальний Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Ваш оригінальний style.css (який містить стилі хедера/футера) -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  
  <!-- 
    !! ВБУДОВАНІ СТИЛІ ЧАТУ !!
  -->
  <style>
    /* --- СТИЛІ ЧАТУ --- */
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
    #chat-toggle-button svg { width: 32px; height: 32px; }

    /* Вікно чату, що плаває */
    #chat-window {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 350px;
        max-height: 500px;
        height: 80vh;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: none; /* Зміниться на 'flex' через JS */
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
        flex-shrink: 0;
    }
    #chat-close-button { cursor: pointer; font-size: 24px; }
    #chat-body { flex-grow: 1; display: flex; flex-direction: column; overflow-y: hidden; }

    /* Список отримувачів */
    #recipient-list {
        padding: 10px;
        overflow-y: auto;
        flex-grow: 1;
    }
    #recipient-list ul { list-style: none; padding: 0; margin: 0; }
    .chat-recipient-item { padding: 12px 10px; border-bottom: 1px solid #f0f0f0; cursor: pointer; font-weight: 500; }
    .chat-recipient-item:hover { background-color: #f9f9f9; }

    /* Вікно повідомлень */
    #message-view {
        display: flex; /* 'flex' за замовчуванням */
        flex-direction: column;
        height: 100%;
    }
    #message-header {
        padding: 10px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }
    #back-to-list { background: none; border: none; font-size: 20px; cursor: pointer; margin-right: 10px; }
    #chat-with-name { font-weight: bold; }
    #message-list {
        flex-grow: 1;
        padding: 10px;
        overflow-y: auto;
        background-color: #f9f9f9;
        display: flex;
        flex-direction: column;
    }
    #message-input-area {
        display: flex;
        border-top: 1px solid #eee;
        padding: 10px;
        flex-shrink: 0;
    }
    #message-input { flex-grow: 1; border: 1px solid #ccc; border-radius: 20px; padding: 8px 12px; }
    #send-message-button { background: none; border: none; cursor: pointer; padding: 0 10px; }
    #send-message-button svg { width: 24px; height: 24px; color: #007bff; }

    /* Бульбашки Повідомлень */
    .message-bubble {
        max-width: 80%;
        padding: 8px 12px;
        border-radius: 15px;
        margin-bottom: 10px;
        width: fit-content;
        position: relative;
    }
    .message-bubble.incoming {
        background-color: #e9e9eb;
        color: #000;
        align-self: flex-start;
    }
    .message-bubble.outgoing {
        background-color: #007bff;
        color: white;
        align-self: flex-end;
    }
    .message-bubble .message-user {
        font-size: 0.8rem;
        font-weight: bold;
        margin-bottom: 4px;
    }
    .message-bubble .message-content {
        word-wrap: break-word;
        padding-right: 25px; /* Місце для галочок */
    }

    /* Статуси Повідомлень (Галочки) */
    .message-status {
        font-size: 0.9rem;
        font-weight: bold;
        position: absolute;
        bottom: 6px;
        right: 10px;
    }
    .status-sent {
        color: #9ab0c7; /* Сіра галочка */
    }
    .status-read {
        color: #4fc3f7; /* Блакитні галочки */
    }
  </style>
  <!-- === КІНЕЦЬ СТИЛІВ ЧАТУ === -->

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

<!-- === HTML ЧАТУ === -->
@auth  
    <div id="chat-toggle-button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25a9.76 9.76 0 01-2.53-.388 1.875 1.875 0 01-1.002-1.002A9.76 9.76 0 013 12c0-4.556 3.86-8.25 8.625-8.25a9.76 9.76 0 012.53.388 1.875 1.875 0 011.002 1.002A9.76 9.76 0 0121 12z" />
        </svg>
    </div>

    <!-- ID поточного користувача -->
    <div id="chat-window" style="display: none;" data-current-user-id="{{ Auth::id() }}">
        <div id="chat-header">
            <span id="chat-header-title">Підтримка</span>
            <span id="chat-close-button">&times;</span>
        </div>
        <div id="chat-body">
            
            <!-- Екран 1: Список користувачів -->
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
            
            <!-- Екран 2: Вікно повідомлень (показується JS) -->
            <div id="message-view" style="display: none;">
                <div id="message-header">
                    <button id="back-to-list">&larr;</button>
                    <span id="chat-with-name"></span>
                </div>
                <div id="message-list">
                    <!-- Повідомлення будуть завантажуватися тут -->
                </div>
                <div id="message-input-area">
                    <input type="text" id="message-input" placeholder="Напишіть повідомлення...">
                    <button id="send-message-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.875L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
@endauth
<!-- === КІНЕЦЬ HTML ЧАТУ === -->


<!-- 
  !! ВБУДОВАНИЙ JAVASCRIPT (ОНОВЛЕНО З ВІДЛАДКОЮ) !!
-->
<!-- 1. Підключення Socket.IO клієнта (з CDN) -->
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>

<!-- 2. !! ВИПРАВЛЕНО: Підключення Laravel Echo (з CDN) !! -->
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.js"></script>

<!-- 3. Наша логіка чату -->
<script>
document.addEventListener('DOMContentLoaded', (event) => {

    // --- Перевірка, чи ми залогінені ---
    const chatWindow = document.getElementById('chat-window');
    if (!chatWindow) {
        console.log('Chat window not found. User might not be logged in. Script stopped.');
        return; // Якщо чату немає, нічого не робимо
    }

    // --- Глобальні змінні ---
    let currentChatId = null; // ID поточного відкритого чату
    let currentChatMessages = {}; // Кеш повідомлень
    const currentUserId = chatWindow.dataset.currentUserId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // --- Елементи DOM ---
    const toggleButton = document.getElementById('chat-toggle-button');
    const closeButton = document.getElementById('chat-close-button');
    const recipientListScreen = document.getElementById('recipient-list');
    const messageViewScreen = document.getElementById('message-view');
    const backButton = document.getElementById('back-to-list');
    const recipientItems = document.querySelectorAll('.chat-recipient-item');
    const chatHeaderTitle = document.getElementById('chat-header-title');
    const chatWithName = document.getElementById('chat-with-name');
    const messageList = document.getElementById('message-list');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-message-button');

    // --- ВІДЛАДКА: Перевірка завантаження бібліотек ---
    console.log('Chat script initializing...');
    if (typeof window.io === 'undefined') {
        console.error('CRITICAL: Socket.IO (window.io) is NOT loaded. Check CDN link.');
        return; // Зупиняємо скрипт
    }
    console.log('Socket.IO is loaded.');

    if (typeof window.Echo === 'undefined') {
        console.error('CRITICAL: Laravel Echo (window.Echo) is NOT loaded. Check CDN link.');
        return; // Зупиняємо скрипт
    }
    console.log('Laravel Echo is loaded.');
    // --- КІНЕЦЬ ВІДЛАДКИ ---


    // --- Ініціалізація Echo ---
    let Echo; // Оголошуємо Echo
    try {
        Echo = new window.Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ':6001', // Наш Node.js сервер
            auth: {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            },
        });
        console.log('Echo initialized successfully.');
    } catch (e) {
        console.error('CRITICAL: Failed to initialize Echo constructor.', e);
        return; // Зупиняємо скрипт, якщо конструктор впав
    }

    // --- Функції ---
    // (Тут всі ваші функції: displayMessage, updateAllMessageStatuses, і т.д.)

    /**
     * Відображає одне повідомлення у вікні чату
     */
    function displayMessage(message, isPending = false) {
        const bubble = document.createElement('div');
        bubble.classList.add('message-bubble');
        
        // Встановлюємо ID для майбутніх оновлень
        bubble.dataset.messageId = message.id; 

        if (message.user_id == currentUserId) {
            bubble.classList.add('outgoing');
            
            const content = document.createElement('div');
            content.classList.add('message-content');
            content.innerText = message.content;
            
            const statusIcon = document.createElement('span');
            statusIcon.classList.add('message-status');
            
            if (isPending || !message.status) {
                statusIcon.classList.add('status-sent');
                statusIcon.innerText = '✓'; // 1 сіра галочка (в процесі)
            } else if (message.status === 'read') {
                statusIcon.classList.add('status-read');
                statusIcon.innerText = '✓✓'; // 2 блакитні галочки (прочитано)
            } else {
                statusIcon.classList.add('status-sent');
                statusIcon.innerText = '✓'; // 1 сіра галочка (відправлено)
            }
            
            bubble.appendChild(content);
            bubble.appendChild(statusIcon);
            
        } else {
            bubble.classList.add('incoming');
            
            const userName = document.createElement('div');
            userName.classList.add('message-user');
            userName.innerText = message.user.name;
            bubble.appendChild(userName);

            const content = document.createElement('div');
            content.classList.add('message-content');
            // Вхідні повідомлення не мають галочок
            content.style.paddingRight = '0'; 
            content.innerText = message.content;
            bubble.appendChild(content);
        }

        messageList.appendChild(bubble);
    }

    /**
     * Оновлює статус галочок для всіх наших повідомлень
     */
    function updateAllMessageStatuses(chatId) {
        if (chatId != currentChatId) return; // Оновлюємо тільки активний чат

        const bubbles = messageList.querySelectorAll('.message-bubble.outgoing');
        bubbles.forEach(bubble => {
            const icon = bubble.querySelector('.message-status');
            if (icon && !icon.classList.contains('status-read')) {
                icon.classList.remove('status-sent');
                icon.classList.add('status-read');
                icon.innerText = '✓✓';
            }
        });
    }

    /**
     * Прокручує чат до останнього повідомлення
     */
    function scrollToBottom() {
        messageList.scrollTop = messageList.scrollHeight;
    }

    /**
     * Перемикає екрани (список або чат)
     */
    function showScreen(screenName) {
        if (screenName === 'messages') {
            recipientListScreen.style.display = 'none';
            messageViewScreen.style.display = 'flex';
            chatHeaderTitle.style.display = 'none'; // Ховаємо "Підтримка"
        } else {
            recipientListScreen.style.display = 'block';
            messageViewScreen.style.display = 'none';
            chatHeaderTitle.style.display = 'block'; // Показуємо "Підтримка"
            currentChatId = null; // Вийшли з чату
        }
    }

    /**
     * Повідомляє сервер, що ми прочитали чат (через 'whisper')
     */
    function markChatAsRead(chatId) {
        if (!chatId) return;
        
        try {
            // Знаходимо канал і відправляємо "whisper"
            const channel = Echo.private('chat.' + chatId);
            channel.whisper('read', {
                chat_id: chatId,
                user_id: currentUserId
            });
        } catch (e) {
            console.error("Failed to send whisper:", e);
        }
    }


    /**
     * Завантажує історію чату з сервером (або створює новий чат)
     */
    async function loadChat(recipientId, recipientName) {
        messageList.innerHTML = '';
        chatWithName.innerText = `Чат з ${recipientName}`;
        showScreen('messages');

        try {
            const response = await fetch('/chat/load', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    recipient_id: recipientId
                })
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();
            
            currentChatId = data.chat.id;
            
            // Відображаємо всі повідомлення з кешу або нові
            currentChatMessages[currentChatId] = data.messages;
            data.messages.forEach(msg => displayMessage(msg, false));
            
            // Підписуємося на канал цього чату
            subscribeToChannel(currentChatId);
            
            scrollToBottom();
            
            // Повідомляємо іншим, що ми прочитали повідомлення
            markChatAsRead(currentChatId);

        } catch (error) {
            console.error('Error loading chat:', error);
            chatWithName.innerText = 'Помилка завантаження';
        }
    }

    /**
     * Відправляє нове повідомлення на сервер
     */
    async function sendMessage() {
        const content = messageInput.value.trim();
        if (content === '' || !currentChatId) return;

        const tempId = 'temp_' + Date.now(); // Тимчасовий ID
        const pendingMessage = {
            id: tempId,
            user_id: currentUserId,
            content: content,
            user: { name: 'Me' } // Заглушка
        };
        
        displayMessage(pendingMessage, true); // true = в очікуванні
        scrollToBottom();
        messageInput.value = '';

        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    chat_id: currentChatId,
                    content: content
                })
            });

            if (!response.ok) throw new Error('Failed to send message');

            const newMessage = await response.json();
            
            // Оновлюємо тимчасове повідомлення на справжнє
            const tempBubble = messageList.querySelector(`[data-message-id="${tempId}"]`);
            if (tempBubble) {
                tempBubble.dataset.messageId = newMessage.id;
                // Статус '✓' вже стоїть, оскільки він прийшов з 'sendMessage'
            }
            
            // Додаємо в кеш
            if(currentChatMessages[currentChatId]) {
                 currentChatMessages[currentChatId].push(newMessage);
            }

        } catch (error) {
            console.error('Error sending message:', error);
            const tempBubble = messageList.querySelector(`[data-message-id="${tempId}"]`);
            if (tempBubble) {
                tempBubble.querySelector('.message-content').innerText = "Помилка відправки";
            }
        }
    }

    /**
     * Підписка на приватний канал чату
     */
    function subscribeToChannel(chatId) {
        // Відписуємося від старого каналу, якщо він був
        if (currentChatId && currentChatId !== chatId) {
            try {
                Echo.leave('chat.'M + currentChatId);
            } catch (e) {
                console.warn("Error leaving channel:", e);
            }
        }

        try {
            Echo.private('chat.' + chatId)
                .listen('MessageSent', (e) => {
                    // Нове повідомлення прийшло!
                    console.log('MessageSent event received:', e);
                    
                    // Додаємо в кеш
                    if(currentChatMessages[chatId]) {
                        currentChatMessages[chatId].push(e.message);
                    }

                    // Відображаємо, тільки якщо чат відкритий
                    if (chatId == currentChatId) {
                        displayMessage(e.message, false);
                        scrollToBottom();
                        
                        // Одразу позначаємо як прочитане
                        markChatAsRead(chatId);
                    } else {
                        // TODO: Показати іконку "нове повідомлення" біля юзера
                        console.log('New message in hidden chat', chatId);
                    }
                })
                .listenForWhisper('read', (e) => {
                    // Інший юзер прочитав повідомлення!
                    console.log('Read event received:', e);
                    if (e.user_id != currentUserId) {
                        updateAllMessageStatuses(e.chat_id);
                    }
                });
        } catch (e) {
            console.error("Failed to subscribe to private channel:", e);
        }
    }


    // --- Обробники Подій ---
    console.log('Attaching listeners...');

    // 1. Відкрити вікно чату
    toggleButton.addEventListener('click', () => {
        console.log('Toggle button clicked!'); // ВІДЛАДКА
        chatWindow.style.display = 'flex';
        toggleButton.style.display = 'none';
        showScreen('recipients'); // Завжди починаємо зі списку
    });

    // 2. Закрити вікно чату
    closeButton.addEventListener('click', () => {
        console.log('Close button clicked!'); // ВІДЛАДКА
        chatWindow.style.display = 'none';
        toggleButton.style.display = 'flex';
        // Відписуємося від поточного каналу
        if (currentChatId) {
            try {
                Echo.leave('chat.' + currentChatId);
            } catch (e) {
                console.warn("Error leaving channel on close:", e);
            }
            currentChatId = null;
        }
    });

    // 3. Клік на отримувача зі списку
    recipientItems.forEach(item => {
        item.addEventListener('click', () => {
            console.log('Recipient item clicked:', item.dataset.id); // ВІДЛАДКА
            loadChat(item.dataset.id, item.innerText);
        });
    });

    // 4. Повернення до списку отримувачів
    backButton.addEventListener('click', () => {
        console.log('Back button clicked!'); // ВІДЛАДКА
        showScreen('recipients');
        // Відписуємося від каналу
        if (currentChatId) {
            try {
                Echo.leave('chat.' + currentChatId);
            } catch (e) {
                console.warn("Error leaving channel on back:", e);
            }
            currentChatId = null;
        }
    });

    // 5. Клік на кнопку "Відправити"
    sendButton.addEventListener('click', sendMessage);

    // 6. Відправка по 'Enter'
    messageInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    console.log('All listeners attached successfully.');
    
});
</script>
<!-- === КІНЕЦЬ JAVASCRIPT ЧАТУ === -->

</body>
</html>

