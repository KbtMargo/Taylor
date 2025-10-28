import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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