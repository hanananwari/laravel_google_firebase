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