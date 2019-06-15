<script type="text/javascript" src="/solumax/google-firebase/plugins/all.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/firebasejs/4.8.1/firebase-app.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/firebasejs/4.8.1/firebase-messaging.js"></script>

<script type="text/javascript">
firebase.initializeApp({
    'messagingSenderId': "{{ config('solumax.googleFirebase.firebase.messaging_sender_id') }}"
})

const messaging = firebase.messaging();

if('serviceWorker' in navigator) {
  navigator.serviceWorker
           .register('/firebase-messaging-sw.js')
           .then(function() { console.log("Service Worker Registered"); });
}
</script>
