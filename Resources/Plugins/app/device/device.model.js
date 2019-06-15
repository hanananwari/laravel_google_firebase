solumaxGoogleFirebasePlugins    
    .factory('DeviceModel', function(
        $http) {

        var deviceModel = {}

        var baseUrl = '/solumax/google-firebase/device/';

        deviceModel.index = function(token) {
            return $http.get(baseUrl  +  token)
        }

        deviceModel.get = function(id) {
            return $http.get(baseUrl, id)
        }

        deviceModel.store = function(device) {
            return $http.post(baseUrl, device)
        }

        deviceModel.update = function(id, device) {
            return $http.post(baseUrl + id, device)
        }

        deviceModel.subscribe = function(token, body) {
            return $http.post(baseUrl + token + '/subscribe/', body)
        }

        deviceModel.unsubscribe = function(token, body) {
            return $http.post(baseUrl + token + '/unsubscribe/', body)
        }

        deviceModel.delete = function(id) {
            return $http.delete(baseUrl + id)
        }

        return deviceModel
    })