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
