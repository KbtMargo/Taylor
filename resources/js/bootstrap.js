import axios from 'axios';
import Echo from 'laravel-echo';
import io from 'socket.io-client';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    },
});