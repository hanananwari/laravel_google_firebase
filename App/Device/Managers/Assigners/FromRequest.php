<?php

namespace Solumax\GoogleFirebase\App\Device\Managers\Assigners;

use Solumax\GoogleFirebase\App\Device\DeviceModel;

class FromRequest {

    protected $device;

    public function __construct(DeviceModel $device) {
        $this->device = $device;
    }

    public function assign(\Illuminate\Http\Request $request) {

        $this->device->fill($request->only('user_type','user_id','user_name'));

        return $this->device;
    }

}
