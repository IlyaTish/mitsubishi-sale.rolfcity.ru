<?php

namespace App\Model\Form\UseCase\Mail\Instant;

use App\Core\Mailer\Mailer;
use App\Exception\MailException;
use App\Model\Form\Service\Recipients;
use App\Model\Form\Service\TemplateDataConverter;
use App\Model\Form\UseCase\Form;
use App\Model\Form\UseCase\Mail;
use Slim\Views\Twig;

class Handler implements Mail\Handler {

    private $mailer;
    private $recipients;
    private $view;
    private $templateDataConverter;

    /**
     * Handler constructor.
     * @param Mailer $mailer
     * @param Recipients $recipients
     * @param Twig $view
     * @param TemplateDataConverter $templateDataConverter
     */
    public function __construct(Mailer $mailer, Recipients $recipients, Twig $view, TemplateDataConverter $templateDataConverter) {
        $this->mailer = $mailer;
        $this->recipients = $recipients;
        $this->view = $view;
        $this->templateDataConverter = $templateDataConverter;
    }

    /**
     * @param Form $form
     * @param array $extendedData
     */
    public function handle(Form $form, $extendedData = []) {
        $this->agencySend($form, $extendedData);
        $this->clientSend($form);
    }

    /**
     * @param Form $form
     * @param $extendedData
     */
    private function agencySend(Form $form, $extendedData) {

        $adminEmail = env('ADMIN');

        if(!$adminEmail)
            throw new MailException('Email администратора не задан!');

        $recipients = array_merge(
            [
                $adminEmail => ''
            ],
            $this->recipients->agency()
        );

        $body = $this->view->fetch('mail.twig', $this->templateDataConverter->convertExt($form, $extendedData));

        $this->mailer->sendCallMessage($recipients, $body);
    }

    /**
     * @param Form $form
     */
    private function clientSend(Form $form) {
        $recipients = $this->recipients->client();
        $body = $this->view->fetch('mail.twig', $this->templateDataConverter->convert($form));

        $this->mailer->sendCallMessage($recipients, $body);
    }
}