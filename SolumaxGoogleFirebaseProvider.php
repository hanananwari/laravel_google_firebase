<?php

namespace Solumax\GoogleFirebase;

use Illuminate\Support\ServiceProvider;

class SolumaxGoogleFirebaseProvider extends ServiceProvider {

    public function boot() {

        require __DIR__ . '/Http/routes.php';

        $this->publishes([
            __DIR__ . '/Database/Migrations' => database_path('migrations/solumax/google-firebase')
                ], 'migrations');

        $this->publishes([
            __DIR__ . '/Public/Plugins' => public_path('solumax/google-firebase/plugins'),
                ], 'public');

        $this->publishes([
            __DIR__ . '/Config/googleFirebase.php' => config_path('solumax/googleFirebase.php'),
                ], 'config');

        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'solumax.googleFirebase');
    }

    public function register() {

        $this->mergeConfigFrom(__DIR__ . '/Config/googleFirebase.php', 'solumax.googleFirebase');

        $this->app->singleton('SolGoogleFirebase', function () {
            return new Facade\SolGoogleFirebase();
        });
    }

}
