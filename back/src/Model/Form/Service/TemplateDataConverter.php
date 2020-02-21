<?php


namespace App\Model\Form\Service;


use App\Model\Form\UseCase\Form;

class TemplateDataConverter {

    /**
     * @param Form $form
     * @param $extraData
     * @return array
     */
    public function convertExt(Form $form, $extraData) {

        $data = $this->convert($form);

        $call_keeper_enable = env('CK_ENABLE');

        if($call_keeper_enable) {
            $data['back_ck'] = [
                'call_id' => array_get($extraData, 'id'),
                'client_phone' => array_get($extraData, 'client'),
                'manager_phone' => array_get($extraData, 'manager'),
                'referrer' => $form->referrer,
                'ga_id' => $form->ga_client_id
            ];
        } elseif (!is_null($form->ck_status)) {
            $data['front_ck'] = [
                'status' => $form->ck_status == 1 ? 'success' : 'failed',
                'message' => $form->ck_message
            ];
        }
        return $data;
    }

    /**
     * @param Form $form
     * @return array
     */
    public function convert(Form $form) {
        return [
            'url' => $form->url,
            'host' => $form->getHost(),
            'form_type' => $form->autoType(),
            'path' => $form->path,
            'phone' => $form->phone,
            'utm_source' => $form->utm_source,
            'utm_medium' => $form->utm_medium,
            'utm_campaign' => $form->utm_campaign,
            'utm_content' => $form->utm_content,
            'utm_term' => $form->utm_term,
            'ip' => $form->ip,
            'user_agent' => $form->user_agent
        ];
    }
}