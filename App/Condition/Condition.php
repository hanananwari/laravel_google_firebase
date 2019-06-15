<?php

namespace Solumax\GoogleFirebase\App\Condition;

class Condition {

    protected $condition;
    protected $topic;
    
    public function __construct(string $topic, string $condition) {
        $this->condition = $condition;
        $this->topic = $topic;

    }

    public function retrieve() {

        $topics = str_replace(',', ' in topics ', $this->topic);

        $condition = str_replace('*', $this->condition, $topics);

        return $condition;

    }
    public function send($payload) {

        \SolGoogleFirebase::webPushNotification()->sendWithCondition($this->retrieve(), $payload);
  }

}
