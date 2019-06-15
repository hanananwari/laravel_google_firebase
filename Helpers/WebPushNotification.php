<?php

namespace Solumax\GoogleFirebase\Helpers;

use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\ServiceAccount;

class WebPushNotification
{

    public function __construct()
    {

        $serviceAccount = ServiceAccount::fromJsonFile(storage_path(config('solumax.googleFirebase.firebase.service_account_path')));

        $this->firebase = (new Firebase\Factory())
            ->withServiceAccount($serviceAccount)
            ->create();

        $this->messaging = $this->firebase->getMessaging();
    }

    public function sendByTopic($topic, $payload)
    {

        $message = CloudMessage::fromArray([
            'topic' => $topic,
            'webpush' => $payload,
        ]);

        $this->messaging->send($message);
    }

    public function sendToSpecificDevice($token, $topic, $payload)
    {

        $message = CloudMessage::fromArray([
            'token' => $token,
            'topic' => $topic,
            'webpush' => $payload,
        ]);

        $this->messaging->send($message);
    }

    public function sendWithCondition($condition, $payload)
    {

        $message = CloudMessage::fromArray([
            'condition' => $condition,
            'webpush' => $payload,
        ]);

        $this->messaging->send($message);
    }

    public function sendToMultipleDevices(array $tokens, $payload)
    {

        $message = CloudMessage::fromArray([
            'webpush' => $payload,
        ]);

        $this->messaging->sendMulticast($message, $tokens);

    }

    public function subscribe($topic, $deviceIds)
    {

        $this->firebase
            ->getMessaging()
            ->subscribeToTopic($topic, $deviceIds);
    }

    public function unsubscribe($topic, $deviceIds)
    {

        $this->firebase
            ->getMessaging()
            ->unsubscribeFromTopic($topic, $deviceIds);
    }

}
