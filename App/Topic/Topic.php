<?php

namespace Solumax\GoogleFirebase\App\Topic;

use Illuminate\Database\Eloquent\Collection;
use Solumax\GoogleFirebase\App\Device\DeviceModel;

class Topic {

    protected $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function subscribeOne(DeviceModel $device) {

        \SolGoogleFirebase::webPushNotification()->subscribe($this->name, [$device->token]);
    }

    public function unsubscribeOne(DeviceModel $device) {

        \SolGoogleFirebase::webPushNotification()->unsubscribe($this->name, [$device->token]);
    }

    public function subscribeMany(Collection $devices) {
        
    }

    public function unsubscribeMany(Collection $devices) {
        
    }

    public function send($payload) {

         \SolGoogleFirebase::webPushNotification()->sendByTopic($this->name, $payload);
        
    }

}
