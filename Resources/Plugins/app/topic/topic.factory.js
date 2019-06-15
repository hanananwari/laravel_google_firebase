solumaxGoogleFirebasePlugins    
    .factory('TopicFactory', function(
        $http) {

        var deviceModel = {}

        var baseUrl = '/solumax/google-firebase/topic/';

        deviceModel.subscribe = function(device) {
            return $http.post(baseUrl + topic + '/subscribe/', body)
        }

        deviceModel.unsubscribe = function(topic, body) {
            return $http.post(baseUrl + topic + '/unsubscribe/', body)
        }

        deviceModel.delete = function(id) {
            return $http.delete(baseUrl + id)
        }

        return deviceModel
    })