<?php

namespace Solumax\GoogleFirebase\App\Device\Managers\Topics;

use Solumax\GoogleFirebase\App\Device\DeviceModel;

class OnUnsubscribe {

    protected $device;

    public function __construct(DeviceModel $device) {
        $this->device = $device;
    }

    public function topic($topicName) {

        $topic = new \Solumax\GoogleFirebase\App\Topic\Topic($topicName);
        $topic->unsubscribeOne($this->device);
    }

}
