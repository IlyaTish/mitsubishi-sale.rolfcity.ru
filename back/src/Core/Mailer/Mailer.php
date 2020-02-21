<?php

namespace App\Core\Mailer;

use App\Model\Form\Service\MessageHelper;
use \Swift_Mailer;
use Swift_Message;

/**
 * Class Mailer
 * @package App\Core\Mailer
 */
class Mailer {

    private $from;
    private $mailer;
    private $messageHelper;

    /**
     * Mailer constructor.
     * @param Swift_Mailer $mailer
     * @param MessageHelper $messageHelper
     */
    public function __construct(Swift_Mailer $mailer,  MessageHelper $messageHelper) {
        $this->mailer = $mailer;
        $this->from = env('MAIL_EMAIL');
        $this->messageHelper = $messageHelper;
    }


    public function sendCallMessage($recipients, $body) {

        $title = $this->messageHelper->title();
        $subject = $this->messageHelper->callSubject();

        $message = new Swift_Message();

        $message->setFrom($this->from, $title);
        $message->setTo($recipients);
        $message->setSubject($subject);
        $message->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public function sendError($body) {

        $title = $this->messageHelper->title();
        $subject = 'Ошибка на лендинге ' . url_parse(env('URL'), 3);
        $adminEmail = env('ADMIN');

        if(!$adminEmail) return false;

        $message = new Swift_Message();

        $message->setFrom($this->from, $title);
        $message->setTo($adminEmail);
        $message->setSubject($subject);
        $message->setBody($body, 'text/html');

        try {
            $this->mailer->send($message);
        } catch (\Swift_TransportException $e) {
            return false;
        }
    }
}
