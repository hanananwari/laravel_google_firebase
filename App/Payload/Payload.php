<?php

namespace Solumax\GoogleFirebase\App\Payload;

class Payload {

    protected $title;
    protected $body;
    protected $link;
    protected $icon;
    protected $data;

    public function __construct(string $title, string $body, string $link, string $icon, $data = []) {

        $this->title = $title;
        $this->body = $body;
        $this->link = $link;
        $this->icon = $icon;
        $this->data = $data;

    }

    public function generate() {

        return [
            'notification' => [
                'title' => $this->title,
                'body' => $this->body,
                'icon' => $this->icon,
                'click_action' => $this->link
            ]
        ];
    }

}
