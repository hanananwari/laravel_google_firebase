<?php

namespace Solumax\GoogleFirebase\App\Device\Managers\Validators;

use Solumax\GoogleFirebase\App\Device\DeviceModel;

class OnCreate {

    protected $device;

    public function __construct(DeviceModel $device) {
        $this->device = $device;
    }

    public function validate() {
        return true;
    }

    protected function validateExistingToken() {
        
        return DeviceModel::where('token', $this->device->token)
                        ->first();
    }

}
