<?php

namespace Solumax\GoogleFirebase\App\Device\Managers\Actioners;

use Solumax\GoogleFirebase\App\Device\DeviceModel;

class OnCreate {

    protected $device;

    public function __construct(DeviceModel $device) {
        $this->device = $device;
    }

    public function action() {

        if ($this->device->user_type == 'AccountsXolura') {
            $this->device->user_name = \ParsedJwt::getByKey('name');
            $this->device->user_id = \ParsedJwt::getByKey('sub');
        }

        $this->device->save();
    }

}
