importScripts('https://www.gstatic.com/firebasejs/3.6.8/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.6.8/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
var config = {
    apiKey: "AIzaSyC2qar5FZuYqto2L0CvzpQuN5ywyaAVDLs",
    authDomain: "tras-147808.firebaseapp.com",
    databaseURL: "https://tras-147808.firebaseio.com",
    storageBucket: "tras-147808.appspot.com",
    messagingSenderId: "784720832151"
};
firebase.initializeApp(config);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const title = 'Tras';
  const options = {
    body: 'You got a notification.',
    icon: '/images/logo-128.png',
    click_action: "https://tras.pw/notifications"
  };

  return self.registration.showNotification(title, options);
});