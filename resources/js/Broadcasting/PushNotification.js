const applicationServerPublicKey = 'BNEVO0nTays4Yd9z0FaW57B9DTbkKDNqqFHSLC-IzF1tU58dGzIgfCIYg-R3PEb2zHwjObWUT6lTGZe9fu3toD4';

if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register('/js/service-worker.js')
        .then(function(swReg) {
            console.log('Service Worker is registered', swReg);

            swRegistration = swReg;

            $(document).keypress(function(e) {
                if(e.which == 13) {
                    //showNotification();
                }
            });
        })
        .catch(function(error) {
            console.error('Service Worker Error', error);
        });
} else {
    console.warn('Push messaging is not supported');
    pushButton.textContent = 'Push Not Supported';
}

function showNotification() {
    console.log('foobar');
    Notification.requestPermission(function(result) {
        console.log(result);
        if (result === 'granted') {
            navigator.serviceWorker.register('/js/service-worker.js')
                .then(function(registration) {

                registration.showNotification('Vibration Sample', {
                    body: 'Buzz! Buzz!',
                    icon: '../images/touch/chrome-touch-icon-192x192.png',
                    vibrate: [200, 100, 200, 100, 200, 100, 200],
                    tag: 'vibration-sample'
                });
            });
        }
    });
}

