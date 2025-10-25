import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';


import Echo from 'laravel-echo';

// ⚠️ Do NOT import Pusher here — Reverb doesn't use it

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});


// Wait until Reverb is connected
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('✅ Reverb WebSocket connected');

    const channel = window.Echo.connector.pusher.subscribe('tasks');

    channel.bind('pusher:subscription_succeeded', () => {
        console.log('✅ Subscribed to tasks channel');

        // TaskUpdated
        channel.bind('TaskUpdated', (data) => {
            console.log('🎉 TaskUpdated event:', data);
        });

        // TaskCreated
        channel.bind('TaskCreated', (data) => {
            console.log('🎉 TaskCreated event:', data);
        });

        // TaskDeleted
        channel.bind('TaskDeleted', (data) => {
            console.log('🎉 TaskDeleted event:', data);
        });
    });
});


