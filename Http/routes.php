<?php

$middleware = ['wala.jwt.header.parser', 'wala.jwt.header.validation', 'auth.db.optionalOverwrite'];

if (!empty(config('solumax.googleFirebase.middleware.replacement'))) {
    $middleware = config('solumax.googleFirebase.middleware.replacement');
}

if (!empty(config('solumax.googleFirebase.middleware.additional'))) {
    $middleware = array_merge($middleware, config('solumax.googleFirebase.middleware.additional'));
}

Route::group(['namespace' => 'Solumax\GoogleFirebase\Http\Controllers', 'prefix' => 'solumax/google-firebase', 'middleware' => $middleware], function() {

    Route::group(['prefix' => 'topic'], function() {

        Route::group(['namespace' => 'Topic', 'prefix' => '{topicName}'], function() {

            Route::post('subscribe', ['uses' => 'SubscriptionController@subscribe']);
            Route::post('unsubscribe', ['uses' => 'SubscriptionController@unsubscribe']);
        });
    });

    Route::group(['prefix' => 'device'], function() {

        Route::post('/', ['uses' => 'DeviceController@store']);

        Route::group(['namespace' => 'Device'], function() {
            Route::group(['prefix' => '{token}'], function() {
                Route::get('/', ['uses' => 'SubscriptionController@index']);
                Route::post('subscribe', ['uses' => 'SubscriptionController@subscribe']);
                Route::post('unsubscribe', ['uses' => 'SubscriptionController@unsubscribe']);

            });

            Route::group(['prefix' => 'notification'], function() {
                Route::post('send', ['uses' => 'NotificationController@send']);
            });
        });

        Route::delete('{id}', ['uses' => 'DeviceController@delete']);
    });
});
