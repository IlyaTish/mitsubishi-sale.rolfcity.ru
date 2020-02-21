<?php


namespace App\Model\Form\UseCase\Mail;


use App\Model\Form\UseCase\Form;

interface Handler {

    public function handle(Form $form, $extendedData = []);
}