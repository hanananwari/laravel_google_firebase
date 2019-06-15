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
solumaxGoogleFirebasePlugins
    .directive('notificationCustomer', function (
        DeviceModel, NotificationFactory, $window) {

        return {

            templateUrl: '/solumax/google-firebase/plugins/app/notification/directive/customer/notificationCustomer.html',
            restrict: 'AE',
            scope: {
                topic: '@',
                entityId: '@',
                entityName: '@',
                tenantId:'@'
            },
            link: function (scope, elem, attrs) {

                if (!localStorage.getItem('token')) {
                    $window.onload = function () {

                        $('#notification-modal').modal('show')

                    };
                }


                scope.subscribe = function () {

                    NotificationFactory.getToken()
                        .then(function (token) {

                            DeviceModel.store({
                                token: token,
                                user_type: 'Entity',
                                user_id: scope.entityId,
                                user_name: scope.entityName,
                                tenant_id:scope.tenantId
                            })
                                .then(function (res) {
                                    localStorage.setItem('token', res.data.data.token)
                                })
                        })

                }
            }
        }
    })

solumaxGoogleFirebasePlugins
.directive('notificationInternal', function(
    ConfigModel,
    DeviceModel, NotificationFactory) {

    return {
        templateUrl: '/solumax/google-firebase/plugins/app/notification/directive/internal/notificationInternal.html',
        restrict: 'AE',
        scope: {
                topic: '@', // {"sales_order_generate":"SPK dibuat","sales_order_request":"SPK direquest"}
            },
            link: function(scope, elem, attrs) {

                scope.modalId = Math.random().toString(36).substring(2, 7)

                scope.updateStatus = function(topic) {

                    var topicCode = topic.code;

                    if (!topic.subscribe) {
                        scope.unsubscribe(topicCode)
                    } else {
                        scope.subscribe(topicCode)
                    }
                }

                scope.subscribe = function(topic) {

                    NotificationFactory.getToken()

                        .then(function(token) {

                            DeviceModel.store({
                                    token: token,
                                    user_type: 'AccountsXolura',
                                })
                                .then(function(res) {
                                    DeviceModel.subscribe(token, { topic: topic })
                                })
                        })

                    $('#notification-' + scope.modalId).modal('hide')
                }

                scope.unsubscribe = function(topic) {

                    NotificationFactory.getToken()
                        .then(function(token) {
                            DeviceModel.unsubscribe(token, { topic: topic })
                        })

                    $('#notification-' + scope.modalId).modal('hide')
                }


                scope.loadTopics = function() {

                    NotificationFactory.getToken()
                        .then(function(token) {

                            ConfigModel.get('solumax.googleFirebase.topicGroups')
                                .then(function(res) {

                                    scope.topicGroups = _.get(res.data.data, attrs.topic, []);

                                    DeviceModel.index(token)
                                        .then(function(res) {

                                            scope.topics = res.data.data.rel.topics
                                            _.each(scope.topicGroups, function(topicGroup) {
                                                _.map(scope.topics, function(key, val) {
                                                    if (topicGroup.code == val) {
                                                        topicGroup.subscribe = true;
                                                    }
                                                })

                                            })
                                        })
                                })
                        })
                }
                
                scope.loadTopics()
            }
        }
    })
//# sourceMappingURL=all.js.map
