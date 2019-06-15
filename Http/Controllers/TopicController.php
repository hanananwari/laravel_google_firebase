<?php

namespace Solumax\GoogleFirebase\Http\Controllers;

use Solumax\PhpHelper\Http\Controllers\ApiBaseV2Controller as Controller;
use Illuminate\Http\Request;

class TopicController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->device = new \Solumax\GoogleFirebase\App\Device\DeviceModel();

        $this->transformer = new \Solumax\GoogleFirebase\App\Device\Transformers\DeviceTransformer();
        $this->dataName = 'devices';
    }

    public function store(Request $request) {

        $device = $this->device->firstOrNew(['token' => $request->get('token')]);
        $device->assign()->fromRequest($request);

        $validation = $device->validate()->onCreate();
        if ($validation !== true) {
            return $this->formatErrors($validation);
        }

        $device->action()->onCreate();

        return $this->formatItem($device);
    }

    public function delete($id, Request $request) {

        if ($id) {
            $device = $this->device->find($id);
        } else {
            $device = $this->device->where('token', $request->get('token'))->first();
        }

        $device->delete();

        return response()->json(true);
    }

}
