// Use Firebase v8.x.x for compatibility with service workers
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

// Initialize Firebase with your config
firebase.initializeApp({
    apiKey: 'AIzaSyBTBWP_5d-Jq-n4Vdg4tlqt-Pysg56yQXk',
    authDomain: 'dintest-1e036.firebaseapp.com',
    projectId: 'dintest-1e036',
    storageBucket: 'dintest-1e036.firebasestorage.app',
    messagingSenderId: '41266953605',
    appId: '1:41266953605:web:cd2cb3a0963b189b8618ec',
});

// Initialize Firebase Messaging
const messaging = firebase.messaging();

// Handle background messages
messaging.setBackgroundMessageHandler(function (payload) {
    console.log('[firebase-messaging-sw.js] Background message received', payload);

    // Customize notification here
    const notificationTitle = payload.data.title || "New Notification";
    const notificationOptions = {
        body: payload.data.message || "You have a new update!",
        icon: '/firebase-logo.png', // Optionally use an icon
        data: {
            url: payload.data.url // Include URL to open when notification is clicked
        }
    };

    // Show the notification
    return self.registration.showNotification(notificationTitle, notificationOptions);
});

// Handle notification click events
self.addEventListener('notificationclick', function (event) {
    console.log('Notification clicked', event.notification.data.url);

    // Close the notification
    event.notification.close();

    // Open the URL associated with the notification (if present)
    const url = event.notification.data.url;
    if (url) {
        event.waitUntil(
            clients.openWindow(url)
        );
    }
});

