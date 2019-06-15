<?php

namespace Solumax\GoogleFirebase\Http\Controllers\Device;

use Solumax\PhpHelper\Http\Controllers\ApiBaseV2Controller as Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->device = new \Solumax\GoogleFirebase\App\Device\DeviceModel();
        $this->transformer = new \Solumax\GoogleFirebase\App\Device\Transformers\DeviceTransformer;
    }

    public function index($token) {

        $device = $this->device->where('token', $token)->first();

        $topics = $device->topic()->retrieve();

        return $this->formatData($topics);
    }

    public function subscribe($token, Request $request) {

        $device = $this->device->where('token', $token)->first();

        $device->topic()->onSubscribe($request->get('topic'));

        return $this->formatData(true);
    }

    public function unsubscribe($token, Request $request) {

        $device = $this->device->where('token', $token)->first();

        $device->topic()->onUnsubscribe($request->get('topic'));

        return $this->formatData(true);
    }

}
