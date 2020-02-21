<?php


namespace App\Model\Form\Service;


class MessageHelper {

    private $host;

    public function __construct() {
        $this->host = url_parse(env('URL'), 3);
    }

    public function title() {
        $env_from_name = env('MAIL_TITLE');
        return !empty($env_from_name) ? $env_from_name : 'LandingPage ' . $this->host;
    }

    public function callSubject() {
        return 'Запрос обратного звонка ' . $this->host;
    }
}