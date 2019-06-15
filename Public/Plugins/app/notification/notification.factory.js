solumaxGoogleFirebasePlugins
    .factory('NotificationFactory', function(
        $q) {

        var notificationFactory = {}

        notificationFactory.requestPermission = function() {

            return $q(function(resolve, reject) {

                messaging.requestPermission()
                    .then(function(permission) {
                        resolve(permission)
                    }).catch(function(err) {
                        reject(err)
                    })
            })
        }

        notificationFactory.getToken = function() {

            return $q(function(resolve, reject) {

                messaging.getToken()
                    .then(function(currentToken) {
                        resolve(currentToken)
                    }).catch(function(err) {
                        reject(err)
                    })
            })
        }

        return notificationFactory
    })