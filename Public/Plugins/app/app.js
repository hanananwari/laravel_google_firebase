var solumaxGoogleFirebasePlugins = angular
.module('Solumax.GoogleFirebasePlugins', [])
.run(function (DeviceModel, NotificationFactory, $rootScope) {


        /*

        Untuk Accounts Xolura

        */

        var isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        if (isSafari || iOS) {

            alert('Anda tidak akan menerima notifikasi')

        } else{

            NotificationFactory.requestPermission()
            .then(function (permission) {

                if (!localStorage.getItem("token") && localStorage.getItem("solumax_jwt_token")) {

                    console.log("Storing Token to Device Table")

                    NotificationFactory.getToken()
                    .then(function (token) {

                        DeviceModel.store({
                            token: token,
                            user_type: 'AccountsXolura'
                        }).then(function (res) {
                            localStorage.setItem('token', res.data.data.token)
                        })
                    })
                }

            }, function (err) {
                alert('Anda tidak akan menerima notifikasi')
                console.log(err)
            })

        }

        messaging.onMessage(function (payload) {

            console.log("Message received. ", payload);
            navigator.serviceWorker.ready.then(function (reg) {
                reg.showNotification(payload.notification.title, payload.notification);
            });
        })


        $rootScope.$on('AccountsXolura_LoggedOut', function (event, data) {

            // Belum dibuat
        })
    })