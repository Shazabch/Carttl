<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FCM Device Token Generator</title>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"></script>
</head>
<body>
    <h1>Firebase Cloud Messaging Device Token</h1>
    <button id="getTokenBtn">Get Device Token</button>
    <p><strong>Token:</strong> <span id="tokenOutput">Not generated yet</span></p>

    <script>
        // Your Firebase config
        const firebaseConfig = {
            apiKey: "AIzaSyAQSazOkww2T7W1DzH6Mg8J-v-ksWW4Se0",
            authDomain: "caartl.firebaseapp.com",
            projectId: "caartl",
            storageBucket: "caartl.firebasestorage.app",
            messagingSenderId: "919267898292",
            appId: "1:919267898292:web:ea7aae0efa897e1cfd78e1",
            measurementId: "G-RNVXK253ZN"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        document.getElementById('getTokenBtn').addEventListener('click', async () => {
            try {
                // Register service worker
                const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');

                // Request permission for notifications
                const permission = await Notification.requestPermission();
                if (permission !== 'granted') {
                    throw new Error('Notification permission denied');
                }

                // Get FCM device token
                const token = await messaging.getToken({
                    vapidKey: "BJ1UELylWQYa0E4s_7FTo-ZkK86ADUSm9ufvyqUsxwZ07e1TOwzUzLyWyCNOen7BEg0w60ctL58LXghHE1o9UWE", // Replace with your VAPID key from Firebase console
                    serviceWorkerRegistration: registration
                });

                document.getElementById('tokenOutput').innerText = token;
                console.log('FCM Device Token:', token);

            } catch (err) {
                console.error('Error getting token:', err);
                document.getElementById('tokenOutput').innerText = 'Error: ' + err;
            }
        });
    </script>
</body>
</html>
