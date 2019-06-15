<?php

namespace Solumax\GoogleFirebase\App\Device\Transformers;

use League\Fractal;
use Solumax\GoogleFirebase\App\Device\DeviceModel;

class DeviceTransformer extends Fractal\TransformerAbstract {

    public function transform(DeviceModel $device) {

        return [
            'id' => $device->id,
            'token' => $device->token,
            'user_type' => $device->user_type,
            'user_id' => $device->user_id,
            'user_name' => $device->user_name,
            'created_at' => $device->created_at->toDateTimeString(),
            'updated_at' => $device->updated_at ? $device->updated_at->toDateTimeString() : null
        ];
    }

}
