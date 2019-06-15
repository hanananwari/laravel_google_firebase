<?php

namespace Solumax\GoogleFirebase\App\Device\Managers;

use Solumax\GoogleFirebase\App\Device\DeviceModel;

class QueryBuilder {

    protected $device;

    public function __construct(DeviceModel $device) {
        $this->device = $device;
    }

    public function build(\Illuminate\Http\Request $request) {

        $query = $this->device->newQuery();

        if ($request->has('user_type')) {
            $query->where('user_type', $request->get('user_type'));
        }

        if ($request->has('user_ids')) {
            $query->whereIn('user_id', explode(',', $request->get('user_ids')));
        }

        return $query;
    }

}
