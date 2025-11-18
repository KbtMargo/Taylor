import axios from 'axios';
import Echo from 'laravel-echo';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: 'http://127.0.0.1:6001',
});


import './echo';
