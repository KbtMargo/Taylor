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
    #chat-toggle-button { position: fixed; bottom: 20px; right: 20px; background-color: #007bff; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; justify-content: center; align-items: center; cursor: pointer; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 9998; }
    #chat-toggle-button svg { width: 32px; height: 32px; }
    #chat-window { position: fixed; bottom: 90px; right: 20px; width: 350px; max-height: 500px; height: 80vh; background-color: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); display: none; flex-direction: column; z-index: 9999; }
    #chat-header { background-color: #007bff; color: white; padding: 10px 15px; border-top-left-radius: 10px; border-top-right-radius: 10px; display: flex; justify-content: space-between; align-items: center; font-weight: bold; flex-shrink: 0; }
    #chat-close-button { cursor: pointer; font-size: 24px; }
    #chat-body { flex-grow: 1; display: flex; flex-direction: column; overflow-y: hidden; position: relative; }

    #recipient-list { display: flex; flex-direction: column; height: 100%; }
    #recipient-list-header { padding: 10px; border-bottom: 1px solid #eee; flex-shrink: 0; }
    #create-group-btn { width: 100%; }
    #recipient-scroll-area { overflow-y: auto; flex-grow: 1; }
    #recipient-scroll-area ul { list-style: none; padding: 0; margin: 0; }
    .chat-list-item { display: flex; align-items: center; padding: 12px 10px; border-bottom: 1px solid #f0f0f0; cursor: pointer; }
    .chat-list-item:hover { background-color: #f9f9f9; }
    .chat-list-item .icon { margin-right: 10px; color: #6c757d; }
    .chat-list-item .name { font-weight: 500; }

    #message-view { display: none; flex-direction: column; height: 100%; }
    #message-header { padding: 10px; border-bottom: 1px solid #eee; display: flex; align-items: center; flex-shrink: 0; }
    #back-to-list { background: none; border: none; font-size: 20px; cursor: pointer; margin-right: 10px; }
    #chat-with-name { font-weight: bold; }
    #message-list { flex-grow: 1; padding: 10px; overflow-y: auto; background-color: #f9f9f9; display: flex; flex-direction: column; }
    #message-input-area { display: flex; border-top: 1px solid #eee; padding: 10px; flex-shrink: 0; }
    #message-input { flex-grow: 1; border: 1px solid #ccc; border-radius: 20px; padding: 8px 12px; }
    #send-message-button { background: none; border: none; cursor: pointer; padding: 0 10px; }
    #send-message-button svg { width: 24px; height: 24px; color: #007bff; }
    .message-bubble { max-width: 80%; padding: 8px 12px; border-radius: 15px; margin-bottom: 10px; width: fit-content; position: relative; display: flex; align-items: flex-start; gap: 8px; }
    .message-bubble.incoming { background-color: #e9e9eb; color: #000; align-self: flex-start; }
    .message-bubble.outgoing { background-color: #007bff; color: white; align-self: flex-end; justify-content: flex-end; }
    .message-bubble .message-user { font-size: 0.8rem; font-weight: bold; margin-bottom: 4px; color: #6c757d; }
    .message-bubble .message-content { word-wrap: break-word; }
    .message-content-wrapper { flex-grow: 1; }
    .message-actions { opacity: 0; transition: opacity 0.2s; }
    .message-bubble:hover .message-actions { opacity: 1; }
    .own-message .message-content-wrapper { order: 1; }
    .own-message .message-actions { order: 2; }

    #create-group-view {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: white;
        z-index: 10;
        display: none;
        flex-direction: column;
        padding: 15px;
    }
    #create-group-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-shrink: 0;}
    #create-group-view h5 { margin: 0; }
    #cancel-group-btn { background: none; border: none; font-size: 24px; cursor: pointer; padding: 0 5px;}
    #create-group-form { display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; }
    #group-participants-list { overflow-y: auto; margin-bottom: 15px; border: 1px solid #eee; padding: 10px; flex-grow: 1;}
    #group-participants-list .form-check { margin-bottom: 5px; }
    #create-group-submit-area { margin-top: auto; flex-shrink: 0; }
    #submit-create-group-btn { width: 100%; }
    .form-error { color: red; font-size: 0.8rem; margin-top: 5px; }
    
    .icon-user::before { content: '👤'; margin-right: 5px; }
    .icon-group::before { content: '👥'; margin-right: 5px; }

    .btn-delete-message {
        background: none;
        border: none;
        color: #ffffff;
        cursor: pointer;
        font-size: 16px;
        margin-left: 8px;
        opacity: 0.7;
        padding: 2px 6px;
    }

    .btn-delete-message:hover {
        opacity: 1;
        background: rgba(255, 68, 68, 0.1);
        border-radius: 3px;
    }

    #delete-chat-btn {
        background: none;
        border: none;
        color: #ff4444;
        cursor: pointer;
        font-size: 18px;
        margin-left: auto;
        padding: 5px 10px;
    }

    #delete-chat-btn:hover {
        background: rgba(255, 68, 68, 0.1);
        border-radius: 4px;
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

@auth  
    <div id="chat-toggle-button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25a9.76 9.76 0 01-2.53-.388 1.875 1.875 0 01-1.002-1.002A9.76 9.76 0 013 12c0-4.556 3.86-8.25 8.625-8.25a9.76 9.76 0 012.53.388 1.875 1.875 0 011.002 1.002A9.76 9.76 0 0121 12z" />
        </svg>
    </div>

    <div id="chat-window" style="display: none;" data-current-user-id="{{ Auth::id() }}">
        <div id="chat-header">
            <span id="chat-header-title">Чати</span>
            <span id="chat-close-button">&times;</span>
        </div>
        <div id="chat-body">
            
            <div id="recipient-list">
                <div id="recipient-list-header">
                    <button id="create-group-btn" class="btn btn-sm btn-outline-primary">Створити групу</button>
                </div>
                <div id="recipient-scroll-area">
                    <ul>
                        @if(isset($chatGroups) && $chatGroups->count() > 0)
                            @foreach($chatGroups as $group)
                                <li class="chat-list-item" data-id="{{ $group->id }}" data-type="group">
                                     <span class="icon icon-group"></span>
                                     <span class="name">{{ $group->title }}</span>
                                </li>
                            @endforeach
                        @endif
                        @if(isset($chatUsers) && $chatUsers->count() > 0)
                            @foreach($chatUsers as $user)
                                <li class="chat-list-item" data-id="{{ $user->id }}" data-type="user">
                                    <span class="icon icon-user"></span>
                                    <span class="name">{{ $user->name }}</span>
                                </li>
                            @endforeach
                        @endif
                        @if((!isset($chatGroups) || $chatGroups->count() == 0) && (!isset($chatUsers) || $chatUsers->count() == 0))
                             <li>Немає користувачів або груп для чату.</li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <div id="message-view" style="display: none;">
                <div id="message-header">
                    <button id="back-to-list">&larr;</button>
                    <span id="chat-with-name"></span>
                </div>
                <div id="message-list"></div>
                <div id="message-input-area">
                    <input type="text" id="message-input" placeholder="Напишіть повідомлення...">
                    <button id="send-message-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.875L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="create-group-view">
                 <div id="create-group-header">
                    <h5>Створити груповий чат</h5>
                    <button id="cancel-group-btn">&times;</button>
                 </div>
                 <form id="create-group-form">
                     <div class="mb-3">
                         <label for="group-title" class="form-label">Назва групи</label>
                         <input type="text" class="form-control form-control-sm" id="group-title" required>
                         <div id="group-title-error" class="form-error"></div>
                     </div>
                     <label class="form-label">Виберіть учасників (мін. 2)</label>
                     <div id="group-participants-list">
                         @if(isset($chatUsers) && $chatUsers->count() > 0)
                            @foreach($chatUsers as $user)
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="{{ $user->id }}" id="user-{{ $user->id }}">
                                  <label class="form-check-label" for="user-{{ $user->id }}">
                                    {{ $user->name }}
                                  </label>
                                </div>
                            @endforeach
                         @else
                            <p>Немає користувачів для додавання.</p>
                         @endif
                     </div>
                      <div id="group-users-error" class="form-error mb-2"></div>
                     <div id="create-group-submit-area">
                        <button type="submit" id="submit-create-group-btn" class="btn btn-primary btn-sm">Створити</button>
                     </div>
                 </form>
            </div>

        </div>
    </div>
@endauth

<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@^1.11.0/dist/echo.iife.js"></script>

<script>
let currentChatId = null;
let currentChatType = null;
let echoInstance = null;
let currentUserId = null;

window.deleteMessage = function(messageId) {
    if (!confirm('Ви впевнені, що хочете видалити це повідомлення?')) return;

    fetch(`/chat/message/${messageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
            if (messageElement) messageElement.remove();
        } else {
            alert('Помилка при видаленні повідомлення: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Помилка при видаленні повідомлення');
    });
}

window.deleteChat = function(chatId) {
    const activeChat = document.querySelector('.chat-list-item.active');
    const chatType = activeChat ? activeChat.dataset.type : 'private';
    const message = chatType === 'group' 
        ? 'Ви впевнені, що хочете покинути цю групу?' 
        : 'Ви впевнені, що хочете видалити цей чат?';

    if (!confirm(message)) return;

    fetch(`/chat/${chatId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const chatElement = document.querySelector(`.chat-list-item[data-id="${chatId}"]`);
            if (chatElement) chatElement.remove();
            showScreen('recipients');
            alert(data.message);
        } else {
            alert('Помилка при видаленні чату: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Помилка при видаленні чату');
    });
}

function displayMessage(message) {
    const messageList = document.getElementById('message-list');
    if (!messageList || messageList.querySelector(`[data-message-id="${message.id}"]`)) return;

    const isOwnMessage = message.user_id == currentUserId;
    const senderName = (message.user && message.user.name) ? message.user.name : 'Unknown';

    const messageElement = document.createElement('div');
    messageElement.classList.add('message-bubble');
    messageElement.dataset.messageId = message.id;

    if (isOwnMessage) {
        messageElement.classList.add('outgoing');
    } else {
        messageElement.classList.add('incoming');
    }

    const messageContentWrapper = document.createElement('div');
    messageContentWrapper.classList.add('message-content-wrapper');

    if (currentChatType === 'group' && !isOwnMessage) {
        const userName = document.createElement('div');
        userName.classList.add('message-user');
        userName.innerText = senderName;
        messageContentWrapper.appendChild(userName);
    }

    const content = document.createElement('div');
    content.classList.add('message-content');
    content.innerText = message.content;
    messageContentWrapper.appendChild(content);

    const time = document.createElement('small');
    time.classList.add('message-time');
    time.innerText = new Date(message.created_at).toLocaleTimeString();
    messageContentWrapper.appendChild(time);

    messageElement.appendChild(messageContentWrapper);

    if (isOwnMessage) {
        const messageActions = document.createElement('div');
        messageActions.classList.add('message-actions');
        
        const deleteButton = document.createElement('button');
        deleteButton.classList.add('btn-delete-message');
        deleteButton.innerHTML = '×';
        deleteButton.title = 'Видалити повідомлення';
        deleteButton.onclick = () => deleteMessage(message.id);
        
        messageActions.appendChild(deleteButton);
        messageElement.appendChild(messageActions);
    }

    messageList.appendChild(messageElement);
}

function addDeleteChatButton(chatId, chatType) {
    const messageHeader = document.getElementById('message-header');
    const oldDeleteBtn = document.getElementById('delete-chat-btn');
    if (oldDeleteBtn) oldDeleteBtn.remove();
    
    const deleteButton = document.createElement('button');
    deleteButton.id = 'delete-chat-btn';
    deleteButton.innerHTML = '🗑️';
    deleteButton.title = chatType === 'group' ? 'Покинути групу' : 'Видалити чат';
    deleteButton.onclick = () => deleteChat(chatId);
    
    messageHeader.appendChild(deleteButton);
}

function scrollToBottom() {
    const messageList = document.getElementById('message-list');
    setTimeout(() => { if (messageList) messageList.scrollTop = messageList.scrollHeight; }, 50);
}

function showScreen(screenName) {
    const recipientListScreen = document.getElementById('recipient-list');
    const messageViewScreen = document.getElementById('message-view');
    const createGroupView = document.getElementById('create-group-view');
    const chatHeaderTitle = document.getElementById('chat-header-title');
    
    recipientListScreen.style.display = 'none';
    messageViewScreen.style.display = 'none';
    createGroupView.style.display = 'none';
    chatHeaderTitle.style.display = 'none';

    if (screenName === 'messages') {
        messageViewScreen.style.display = 'flex';
    } else if (screenName === 'createGroup') {
        createGroupView.style.display = 'flex';
        chatHeaderTitle.style.display = 'block';
        chatHeaderTitle.innerText = 'Створення групи';
    } else {
        recipientListScreen.style.display = 'flex';
        chatHeaderTitle.style.display = 'block';
        chatHeaderTitle.innerText = 'Чати';
        currentChatId = null;
        currentChatType = null;
    }
}

async function loadChat(itemId, itemType, itemName) {
    const messageList = document.getElementById('message-list');
    const chatWithName = document.getElementById('chat-with-name');
    
    if (messageList) messageList.innerHTML = ''; 
    if (chatWithName) chatWithName.innerText = itemName;
    showScreen('messages');

    if (currentChatId && echoInstance) {
        try { echoInstance.leave('chat.' + currentChatId); } catch (e) { console.warn("Error leaving channel:", e); }
    }

    currentChatId = null; 
    currentChatType = itemType;

    let requestBody = {};
    let url = '/chat/load';

    if (itemType === 'user') {
        requestBody.recipient_id = itemId;
    } else {
        requestBody.chat_id = itemId;
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
            },
            body: JSON.stringify(requestBody)
        });

        if (!response.ok) throw new Error(`Network response error (${response.status})`);
        const data = await response.json();
        
        currentChatId = data.chat.id; 
        currentChatType = data.chat.type;
        
        addDeleteChatButton(currentChatId, currentChatType);
        
        data.messages.forEach(msg => displayMessage(msg));
        
        scrollToBottom();
        subscribeToChannel(currentChatId); 
        
    } catch (error) {
        console.error('Error loading chat:', error);
        if (chatWithName) chatWithName.innerText = 'Помилка';
    }
}

function subscribeToChannel(chatId) {
    if (!chatId || !echoInstance) return;

    try {
        echoInstance.private('chat.' + chatId)
            .listen('MessageSent', (e) => {
                if (!e || !e.message) return;
                if (chatId == currentChatId) {
                    if (!document.querySelector(`[data-message-id="${e.message.id}"]`)) {
                        displayMessage(e.message);
                        scrollToBottom();
                    }
                }
            })
            .listen('MessageDeleted', (e) => {
                const messageElement = document.querySelector(`[data-message-id="${e.messageId}"]`);
                if (messageElement) messageElement.remove();
            })
            .listen('ChatDeleted', (e) => {
                if (currentChatId == e.chatId) {
                    showScreen('recipients');
                    alert('Чат було видалено');
                }
                const chatElement = document.querySelector(`.chat-list-item[data-id="${e.chatId}"]`);
                if (chatElement) chatElement.remove();
            });
    } catch (e) { console.error("Subscription failed:", e); }
}

async function sendMessage() {
    const messageInput = document.getElementById('message-input');
    if (!messageInput) return; 
    const content = messageInput.value.trim();
    if (content === '' || !currentChatId) return;

    const tempId = 'temp_' + Date.now(); 
    const pendingMessage = { id: tempId, user_id: currentUserId, content: content, user: { name: 'Me' } };
    
    displayMessage(pendingMessage); 
    scrollToBottom();
    messageInput.value = '';

    try {
        const response = await fetch('/chat/send', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({ chat_id: currentChatId, content: content })
        });

        if (!response.ok) throw new Error(`Send message error (${response.status})`);
        const newMessage = await response.json();
        
        const tempBubble = document.querySelector(`[data-message-id="${tempId}"]`);
        if (tempBubble) tempBubble.dataset.messageId = newMessage.id;
        
    } catch (error) {
        console.error('Error sending message:', error);
        const tempBubble = document.querySelector(`[data-message-id="${tempId}"]`);
        if (tempBubble) {
            const contentDiv = tempBubble.querySelector('.message-content');
            if (contentDiv) contentDiv.innerText = "Помилка"; 
        }
    }
}

function clearGroupForm() {
    const groupTitleInput = document.getElementById('group-title');
    const groupParticipantsList = document.getElementById('group-participants-list');
    const groupTitleError = document.getElementById('group-title-error');
    const groupUsersError = document.getElementById('group-users-error');
    
    if (groupTitleInput) groupTitleInput.value = '';
    if (groupParticipantsList) {
        const checkboxes = groupParticipantsList.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);
    }
    if (groupTitleError) groupTitleError.innerText = '';
    if (groupUsersError) groupUsersError.innerText = '';
}

async function handleCreateGroupSubmit(event) {
    event.preventDefault();
    const groupTitleError = document.getElementById('group-title-error');
    const groupUsersError = document.getElementById('group-users-error');
    const groupTitleInput = document.getElementById('group-title');
    const groupParticipantsList = document.getElementById('group-participants-list');
    
    groupTitleError.innerText = '';
    groupUsersError.innerText = '';
    const title = groupTitleInput.value.trim();
    const selectedUsers = Array.from(groupParticipantsList.querySelectorAll('input[type="checkbox"]:checked')).map(cb => cb.value);

    let hasError = false;
    if (!title) {
        groupTitleError.innerText = 'Назва групи обов\'язкова.';
        hasError = true;
    }
    if (selectedUsers.length < 2) {
        groupUsersError.innerText = 'Виберіть щонайменше 2 учасників.';
        hasError = true;
    }
    if (hasError) return;

    try {
        const response = await fetch('/chat/create-group', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({ title: title, user_ids: selectedUsers })
        });
        const result = await response.json();

        if (!response.ok) {
            if(result.errors) {
                if (result.errors.title) groupTitleError.innerText = result.errors.title[0];
                if (result.errors.user_ids) groupUsersError.innerText = result.errors.user_ids[0];
            } else {
                groupUsersError.innerText = result.error || 'Помилка створення групи.';
            }
            throw new Error(result.error || 'Validation failed');
        }

        alert('Групу "' + result.title + '" створено!');
        clearGroupForm();
        showScreen('recipients');
        window.location.reload();

    } catch (error) {
        console.error('Error creating group:', error);
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    const chatWindow = document.getElementById('chat-window');
    if (!chatWindow) return; 

    currentUserId = chatWindow.dataset.currentUserId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const toggleButton = document.getElementById('chat-toggle-button');
    const closeButton = document.getElementById('chat-close-button');
    const backButton = document.getElementById('back-to-list');
    const chatListItems = document.querySelectorAll('.chat-list-item');
    const sendButton = document.getElementById('send-message-button');
    const messageInput = document.getElementById('message-input');
    const createGroupBtn = document.getElementById('create-group-btn');
    const createGroupView = document.getElementById('create-group-view');
    const cancelGroupBtn = document.getElementById('cancel-group-btn');
    const createGroupForm = document.getElementById('create-group-form');

    try {
        echoInstance = new window.Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ':6001',
            auth: { headers: { 'X-CSRF-TOKEN': csrfToken } },
        });
    } catch (e) {
        console.error('Failed to initialize Echo.', e);
        return;
    }

    if(toggleButton) { 
        toggleButton.addEventListener('click', () => {
            if (chatWindow) chatWindow.style.display = 'flex';
            if (toggleButton) toggleButton.style.display = 'none';
            showScreen('recipients'); 
        });
    }

    if(closeButton) { 
        closeButton.addEventListener('click', () => {
            if (chatWindow) chatWindow.style.display = 'none';
            if (toggleButton) toggleButton.style.display = 'flex';
            if (currentChatId && echoInstance) {
                try { echoInstance.leave('chat.' + currentChatId); } catch (e) {}
                currentChatId = null; currentChatType = null;
            }
        });
    }

    if(chatListItems) { 
        chatListItems.forEach(item => {
            item.addEventListener('click', () => {
                 const itemId = item.dataset.id;
                 const itemType = item.dataset.type;
                 const itemName = item.querySelector('.name').innerText;
                loadChat(itemId, itemType, itemName);
            });
        });
    }

    if(backButton) { 
        backButton.addEventListener('click', () => {
            showScreen('recipients');
            if (currentChatId && echoInstance) {
                try { echoInstance.leave('chat.' + currentChatId); } catch (e) {}
                currentChatId = null; currentChatType = null;
            }
        });
    }
    
    if(createGroupBtn) {
        createGroupBtn.addEventListener('click', () => {
             clearGroupForm();
             showScreen('createGroup');
        });
    }
    
    if(cancelGroupBtn) {
         cancelGroupBtn.addEventListener('click', () => {
             showScreen('recipients');
         });
    }
    
    if(createGroupForm) {
         createGroupForm.addEventListener('submit', handleCreateGroupSubmit);
    }

    if(sendButton) sendButton.addEventListener('click', sendMessage);
    
    if(messageInput) { 
        messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
        });
    }
});
</script>
</body>
</html>