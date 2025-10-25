import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



// Чекаємо, поки сторінка завантажиться
document.addEventListener('DOMContentLoaded', (event) => {

    // Знаходимо елементи
    const toggleButton = document.getElementById('chat-toggle-button');
    const chatWindow = document.getElementById('chat-window');
    const closeButton = document.getElementById('chat-close-button');
    
    const recipientListScreen = document.getElementById('recipient-list');
    const messageViewScreen = document.getElementById('message-view');
    const backButton = document.getElementById('back-to-list');
    const recipientItems = document.querySelectorAll('.chat-recipient-item');
    const chatWithName = document.getElementById('chat-with-name');

    // Тільки якщо кнопка чату існує на сторінці (тобто користувач залогінений)
    if (toggleButton) {
        
        // 1. Відкрити вікно чату
        toggleButton.addEventListener('click', () => {
            chatWindow.style.display = 'flex'; // Використовуємо flex
            toggleButton.style.display = 'none'; // Ховаємо кнопку-іконку
        });

        // 2. Закрити вікно чату
        closeButton.addEventListener('click', () => {
            chatWindow.style.display = 'none';
            toggleButton.style.display = 'flex'; // Показуємо кнопку-іконку
        });

        // 3. Клік на отримувача зі списку
        recipientItems.forEach(item => {
            item.addEventListener('click', () => {
                const recipientName = item.innerText;
                const recipientId = item.dataset.id;

                // Встановлюємо ім'я в заголовку
                chatWithName.innerText = `Чат з ${recipientName}`;
                
                // (В майбутньому тут буде завантаження історії повідомлень)
                // loadMessages(recipientId); 

                // Переключаємо екрани
                recipientListScreen.style.display = 'none';
                messageViewScreen.style.display = 'flex'; // Використовуємо flex
            });
        });

        // 4. Повернення до списку отримувачів
        backButton.addEventListener('click', () => {
            messageViewScreen.style.display = 'none';
            recipientListScreen.style.display = 'block';
        });
    }

});