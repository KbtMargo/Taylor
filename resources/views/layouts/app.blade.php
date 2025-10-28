<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
    #chat-toggle-button svg { width: 32px; height: 32px; }

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
        display: none; 
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

    #recipient-list {
        padding: 10px;
        overflow-y: auto;
        flex-grow: 1;
    }
    #recipient-list ul { list-style: none; padding: 0; margin: 0; }
    .chat-recipient-item { padding: 12px 10px; border-bottom: 1px solid #f0f0f0; cursor: pointer; font-weight: 500; }
    .chat-recipient-item:hover { background-color: #f9f9f9; }

    #message-view {
        display: flex; 
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
        /* padding-right: 25px; - Видалено */
    }
    /* Видалено стилі для .message-status, .status-sent, .status-read */
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

@auth  
    <div id="chat-toggle-button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25a9.76 9.76 0 01-2.53-.388 1.875 1.875 0 01-1.002-1.002A9.76 9.76 0 013 12c0-4.556 3.86-8.25 8.625-8.25a9.76 9.76 0 012.53.388 1.875 1.875 0 011.002 1.002A9.76 9.76 0 0121 12z" />
        </svg>
    </div>

    <div id="chat-window" style="display: none;" data-current-user-id="{{ Auth::id() }}">
        <div id="chat-header">
            <span id="chat-header-title">Підтримка</span>
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.875L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
@endauth

<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@^1.11.0/dist/echo.iife.js"></script>

<script>
document.addEventListener('DOMContentLoaded', (event) => {

    const chatWindow = document.getElementById('chat-window');
    if (!chatWindow) {
        return; 
    }

    let currentChatId = null; 
    let currentChatMessages = {}; 
    const currentUserId = chatWindow.dataset.currentUserId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
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

    if (typeof window.io === 'undefined') {
        console.error('CRITICAL: Socket.IO (window.io) is NOT loaded.');
        return; 
    }
    if (typeof window.Echo === 'undefined') {
        console.error('CRITICAL: Laravel Echo (window.Echo) is NOT loaded.');
        return; 
    }

    let Echo; 
    try {
        Echo = new window.Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ':6001', 
            auth: {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            },
        });
    } catch (e) {
        console.error('CRITICAL: Failed to initialize Echo constructor.', e);
        return; 
    }

    function displayMessage(message, isPending = false) {
        if (messageList.querySelector(`[data-message-id="${message.id}"]`)) {
            return;
        }

        const bubble = document.createElement('div');
        bubble.classList.add('message-bubble');
        bubble.dataset.messageId = message.id; 

        if (message.user_id == currentUserId) {
            bubble.classList.add('outgoing');
            const content = document.createElement('div');
            content.classList.add('message-content');
            content.innerText = message.content;
            bubble.appendChild(content);
        } else {
            bubble.classList.add('incoming');
            const senderName = (message.user && message.user.name) ? message.user.name : 'Unknown';
            const userName = document.createElement('div');
            userName.classList.add('message-user');
            userName.innerText = senderName;
            bubble.appendChild(userName);

            const content = document.createElement('div');
            content.classList.add('message-content');
            content.style.paddingRight = '0'; 
            content.innerText = message.content;
            bubble.appendChild(content);
        }
        messageList.appendChild(bubble);
    }

    function scrollToBottom() {
        setTimeout(() => {
            if (messageList) { 
                 messageList.scrollTop = messageList.scrollHeight;
            }
        }, 50); 
    }

    function showScreen(screenName) {
        if (screenName === 'messages') {
            if (recipientListScreen) recipientListScreen.style.display = 'none';
            if (messageViewScreen) messageViewScreen.style.display = 'flex';
            if (chatHeaderTitle) chatHeaderTitle.style.display = 'none'; 
        } else {
            if (recipientListScreen) recipientListScreen.style.display = 'block';
            if (messageViewScreen) messageViewScreen.style.display = 'none';
            if (chatHeaderTitle) chatHeaderTitle.style.display = 'block'; 
            currentChatId = null; 
        }
    }

    async function loadChat(recipientId, recipientName) {
        if (messageList) messageList.innerHTML = ''; 
        if (chatWithName) chatWithName.innerText = `Чат з ${recipientName}`;
        showScreen('messages');

        if (currentChatId && typeof Echo !== 'undefined') {
             try {
                Echo.leave('chat.' + currentChatId); 
            } catch (e) {
                console.warn("Error leaving previous channel:", e);
            }
        }
        currentChatId = null; 

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

            if (!response.ok) throw new Error(`Network response was not ok (${response.status})`);
            const data = await response.json();
            
            currentChatId = data.chat.id; 
            
            currentChatMessages[currentChatId] = data.messages;
            data.messages.forEach(msg => displayMessage(msg, false));
            
            scrollToBottom();
            
            subscribeToChannel(currentChatId); 
            
        } catch (error) {
            console.error('Error loading chat:', error);
            if (chatWithName) chatWithName.innerText = 'Помилка завантаження';
        }
    }

    async function sendMessage() {
        if (!messageInput) return; 
        const content = messageInput.value.trim();
        if (content === '' || !currentChatId) return;

        const tempId = 'temp_' + Date.now(); 
        const pendingMessage = {
            id: tempId,
            user_id: currentUserId,
            content: content,
            user: { name: 'Me' } 
        };
        
        displayMessage(pendingMessage, true); 
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

            if (!response.ok) throw new Error(`Failed to send message (${response.status})`);

            const newMessage = await response.json();
            
            const tempBubble = messageList.querySelector(`[data-message-id="${tempId}"]`);
            if (tempBubble) {
                tempBubble.dataset.messageId = newMessage.id; 
                if (newMessage) {
                    if(currentChatMessages[currentChatId]) {
                        const index = currentChatMessages[currentChatId].findIndex(m => m.id === tempId);
                        if (index > -1) {
                            currentChatMessages[currentChatId][index] = newMessage;
                        } else {
                            currentChatMessages[currentChatId].push(newMessage);
                        }
                    }
                }
            } else {
                 displayMessage(newMessage, false);
                 scrollToBottom();
                 if(currentChatMessages[currentChatId]) {
                    currentChatMessages[currentChatId].push(newMessage);
                 }
            }

        } catch (error) {
            console.error('Error sending message:', error);
            const tempBubble = messageList.querySelector(`[data-message-id="${tempId}"]`);
            if (tempBubble) {
                const contentDiv = tempBubble.querySelector('.message-content');
                if (contentDiv) contentDiv.innerText = "Помилка відправки"; 
                const errorIcon = document.createElement('span');
                errorIcon.innerText = ' ⚠️';
                errorIcon.style.color = 'red';
                tempBubble.appendChild(errorIcon);
            }
        }
    }

    function subscribeToChannel(chatId) {
        if (!chatId || !Echo) return; 

        try {
            Echo.private('chat.' + chatId)
                .stopListening('MessageSent') 
                .listen('MessageSent', (e) => {
                    if (!e || !e.message) {
                        console.error("Invalid MessageSent event received:", e);
                        return;
                    }
                    if(currentChatMessages[chatId] && !currentChatMessages[chatId].some(m => m.id === e.message.id)) {
                        currentChatMessages[chatId].push(e.message);
                    }

                    if (chatId == currentChatId) { 
                        if (!messageList.querySelector(`[data-message-id="${e.message.id}"]`)) {
                            displayMessage(e.message, false);
                            scrollToBottom();
                        }
                    } else {
                        // TODO: Додати індикацію непрочитаних
                    }
                });
        } catch (e) {
            console.error("Failed to subscribe to private channel:", e);
        }
    }

    if(toggleButton) { 
        toggleButton.addEventListener('click', () => {
            if (chatWindow) chatWindow.style.display = 'flex';
            if (toggleButton) toggleButton.style.display = 'none';
            showScreen('recipients'); 
        });
    } else {
        console.error("Toggle button not found!");
    }

    if(closeButton) { 
        closeButton.addEventListener('click', () => {
            if (chatWindow) chatWindow.style.display = 'none';
            if (toggleButton) toggleButton.style.display = 'flex';
            if (currentChatId && typeof Echo !== 'undefined') {
                try {
                    Echo.leave('chat.' + currentChatId);
                } catch (e) {
                    console.warn("Error leaving channel on close:", e);
                }
                currentChatId = null;
            }
        });
    } else {
         console.error("Close button not found!");
    }

    if(recipientItems) { 
        recipientItems.forEach(item => {
            item.addEventListener('click', () => {
                loadChat(item.dataset.id, item.innerText);
            });
        });
    } else {
        console.error("Recipient items not found!");
    }

    if(backButton) { 
        backButton.addEventListener('click', () => {
            showScreen('recipients');
            if (currentChatId && typeof Echo !== 'undefined') {
                try {
                    Echo.leave('chat.' + currentChatId);
                } catch (e) {
                    console.warn("Error leaving channel on back:", e);
                }
                currentChatId = null;
            }
        });
    } else {
         console.error("Back button not found!");
    }

    if(sendButton) { 
        sendButton.addEventListener('click', sendMessage);
    } else {
         console.error("Send button not found!");
    }

     if(messageInput) { 
        messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
     } else {
          console.error("Message input not found!");
     }
    
});
</script>

</body>
</html>

