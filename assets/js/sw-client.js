const messaging = firebase.messaging();

messaging.requestPermission()
.then(function() {
  console.log('Notification permission granted.');
  
  messaging.getToken()
  .then(function(currentToken) {
    if (currentToken) {
      sendTokenToServer(currentToken);
      //updateUIForPushEnabled(currentToken);
    } else {
      // Show permission request.
      console.log('No Instance ID token available. Request permission to generate one.');
      // Show permission UI.
      //updateUIForPushPermissionRequired();
    }
  })
  .catch(function(err) {
    console.log('An error occurred while retrieving token. ', err);
  });
})
.catch(function(err) {
  console.log('Unable to get permission to notify.', err);
});

messaging.onTokenRefresh(function() {
  messaging.getToken()
  .then(function(refreshedToken) {
    console.log('Token refreshed.');
    // Indicate that the new Instance ID token has not yet been sent to the
    // app server.
    // Send Instance ID token to app server.
    sendTokenToServer(refreshedToken);
    // ...
  })
  .catch(function(err) {
    console.log('Unable to retrieve refreshed token ', err);
    showToken('Unable to retrieve refreshed token ', err);
  });
});

function sendTokenToServer(token) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "https://tras.pw/page/addpushtoken", true);
  xhr.send("token=" + token);
}