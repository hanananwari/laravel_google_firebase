<?php

namespace Solumax\GoogleFirebase\Facade;

class SolGoogleFirebase {

    public function webPushNotification() {
        return new \Solumax\GoogleFirebase\Helpers\WebPushNotification();
    }
}
