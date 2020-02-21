<?php

namespace App\Model\Form\UseCase;

/**
 * Class Form
 * @package App\Model\Form\UseCase
 */
class Form {

    public $url;
    public $utm_source;
    public $utm_medium;
    public $utm_campaign;
    public $utm_content;
    public $utm_term;
    public $phone;
    public $manager_phone;
    public $path;
    public $type;
    public $debug;
    public $ck_status;
    public $ck_message;
    public $ip;
    public $user_agent;
    public $ga_client_id;
    public $referrer;

    /**
     * @param array $data
     * @param $ip
     * @param $user_agent
     * @return Form
     */
    public static function create(array $data, $ip, $user_agent) {
        $form = new self();
        $url = array_get($data, 'url', '');
        $form->url = url_parse($url);
	    $queryString = parse_url($url, PHP_URL_QUERY);
	    $form->setUtm($queryString);
        $form->phone = array_get($data, 'phone');
        $form->manager_phone = array_get($data, 'manager_phone', 0);
        $form->path = array_get($data, 'path');
        $form->type = array_get($data, 'type', 0);
        $form->debug = array_get($data, 'debug', 0);
        $form->ck_status = array_get($data, 'ck_log.status');
        $form->ck_message = array_get($data, 'ck_log.message');
        $form->ip = $ip;
        $form->user_agent = $user_agent;
        $form->ga_client_id = array_get($data, 'ga_client_id', '');
        $form->referrer = array_get($data, 'referrer', '');
        return $form;
    }

    /**
     * @return string
     */
    public function getHost() {
        return url_parse($this->url, 3);
    }

    /**
     * @return string
     */
    public function autoType()  {
        $tool = 'Форма ';

        switch($this->type) {
            case 1:  $tool .= 'в отдел продаж';break;
            case 2:  $tool .= 'в отдел кредитования';break;
            case 3:  $tool .= 'в отдел сервиса';break;
            case 4:  $tool .= 'на тест-драйв';break;
            default: $tool .= 'в отдел продаж';
        }
        return $tool;
    }

    /**
     * @param $query
     * @return void
     */
    private function setUtm($query) {

        parse_str($query,$output);
        foreach ($output as $mark => $value) {
            switch ($mark) {
                case 'utm_source':
                    $source = $value;
                    break;
                case 'utm_medium':
                    $medium = $value;
                    break;
                case 'utm_campaign':
                    $campaign = $value;
                    break;
                case 'utm_content':
                    $content = $value;
                    break;
                case 'utm_term':
                    $term = $value;
                    break;
            }
        }

        $this->utm_source = isset($source) && !empty($source) ? $source : '';
        $this->utm_medium = isset($medium) && !empty($medium) ? $medium : '';
        $this->utm_campaign = isset($campaign) && !empty($campaign) ? $campaign : '';
        $this->utm_content = isset($content) && !empty($content) ? $content : '';
        $this->utm_term = isset($term) && !empty($term) ? $term : '';
    }
}