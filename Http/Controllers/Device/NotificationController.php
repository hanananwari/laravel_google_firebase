<?php

namespace Solumax\GoogleFirebase\Http\Controllers\Device;

use Solumax\PhpHelper\Http\Controllers\ApiBaseV2Controller as Controller;
use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;
use Kreait\Firebase\ServiceAccount;

class NotificationController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->device = new \Solumax\GoogleFirebase\App\Device\DeviceModel();
        $this->transformer = new \Solumax\GoogleFirebase\App\Device\Transformers\DeviceTransformer;
    }

    /*
     * Untuk test kirim notification
     * 
     * Request:
     *  Headers: Authorization Bearer
     *  Body:
     *      user_ids
     *      user_type
     *      title
     *      body
     * 
     */
    public function send(Request $request) {

        $query = $this->device->queryBuilder()->build($request);

        $devices = $query->get();

        $notification = Notification::fromArray([
                    'title' => $request->get('title', 'title'),
                    'body' => $request->get('body', 'body')
        ]);

        $message = CloudMessage::
                withTarget('token', $devices->first()->token)
                ->withNotification($notification);

        $serviceAccount = ServiceAccount::fromJsonFile(storage_path(config('solumax.googleFirebase.firebase.service_account_path')));

        $firebase = (new Firebase\Factory())
                ->withServiceAccount($serviceAccount)
                ->create();

        $messaging = $firebase->getMessaging();

        try {
            $firebase->getMessaging()->validate($message);
        } catch (InvalidMessage $e) {
            print_r($e->errors());
        }

        $messaging->send($message);

        for ($x = 1; $x < count($devices); $x++) {
            $message->withChangedTarget('token', $devices[$x]->token);
        }

        return $this->formatData(true);
    }

}
