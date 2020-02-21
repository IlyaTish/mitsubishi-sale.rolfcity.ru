<?php


namespace App\Model\Form\UseCase\Callkeeper;

use App\Exception\CallKeeperApiException;
use App\Model\Form\UseCase\Form;

class Handler {

    const REQUEST_URL = 'https://api.callkeeper.ru/orderCall';

    public function handle(Form $form) {

        $apiak = env('CK_APIAK');
        $whash = env('CK_WHASH');

        if(empty($apiak))
            throw new CallKeeperApiException('Ключ для Callkeeper API не задан!');

        if(empty($whash))
            throw new CallKeeperApiException('Hash виджета для Callkeeper API не задан!');

        $text_to_manager = 'Посетитель заполнил форму на сайте ' . $form->getHost();

        $params = [
            'unique' => $form->getHost(),
            'apiak' => $apiak,
            'whash' => $whash,
            'utc' => 'Europe/Moscow',
            'ga_client_id' => $form->ga_client_id,
            'tool_name' => $form->autoType(),
            'ip_client' => $form->ip,
            'referrer' => $form->referrer,
            'client' => $form->phone,
            'manager' => $form->manager_phone,
            'text_to_manager' => $text_to_manager,
            'site' => $form->getHost(),
            'utm_source' => $form->utm_source,
            'utm_medium' => $form->utm_medium,
            'utm_campaign' => $form->utm_campaign,
            'utm_content' => $form->utm_content,
            'utm_term' => $form->utm_term,
            'entry_point' => $form->url,
            'user_agent' => $form->user_agent
        ];

        $curl = curl_init(self::REQUEST_URL);
        curl_setopt_array($curl, [
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_CONNECTTIMEOUT => 30
        ]);

        $response = json_decode(curl_exec($curl), true);
        $response = (isset($response[0]) && !empty($response[0])) ? $response[0] : ['status' => 'failed', 'reason' => curl_error($curl)];

        curl_close($curl);

        $apiResponse = [
            'status' => array_get($response, 'status'),
            'id' => array_get($response, 'id'),
            'manager' => array_get($response, 'manager'),
            'client' => array_get($response, 'client')
        ];

        if($apiResponse['status'] != 'success')
            throw new CallKeeperApiException('Отпрака в Callkeeper API провалилась!', ['reason' => array_get($response, 'reason', '')]);

        return $apiResponse;
    }
}