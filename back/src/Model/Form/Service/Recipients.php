<?php


namespace App\Model\Form\Service;


class Recipients {

    /**
     * @return array
     */
    public function agency() {
        return env('RECIPIENTS_AGENCY');
    }

    /**
     * @return array
     */
    public function client() {
        return env('RECIPIENTS_CLIENT');
    }
}