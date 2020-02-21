<?php

namespace App\Model\Form\UseCase\Mail\Queue;

use App\Exception\MailException;
use App\Model\Form\Service\MessageHelper;
use App\Model\Form\Service\PasswordHasher;
use App\Model\Form\Service\Recipients;
use App\Model\Form\Service\TemplateDataConverter;
use App\Model\Form\UseCase\Form;
use \PDO;
use App\Model\Form\UseCase\Mail;
use Slim\Views\Twig;

class Handler implements Mail\Handler {

    private $pdo;
    private $view;
    private $recipients;
    private $templateDataConverter;
    private $passwordHasher;
    private $messageHelper;

    public function __construct(
        PDO $pdo,
        Twig $view,
        Recipients $recipients,
        TemplateDataConverter $templateDataConverter,
        PasswordHasher $passwordHasher,
        MessageHelper $messageHelper
    ) {
        $this->pdo = $pdo;
        $this->view = $view;
        $this->recipients = $recipients;
        $this->templateDataConverter = $templateDataConverter;
        $this->passwordHasher = $passwordHasher;
        $this->messageHelper = $messageHelper;
    }

    public function handle(Form $form, $extendedData = []) {

        $configId = $this->getConfigId();
        $title = $this->messageHelper->title();
        $subject = $this->messageHelper->callSubject();
        $adminEmail = env('ADMIN');

        if(!$adminEmail)
            throw new MailException('Email администратора не задан!');

        $stmt = $this->pdo->prepare("INSERT INTO mails (config,title,subject,recipients,body) VALUES (:config,:title,:subject,:recipients,:body)");

        $stmt->execute([
            'config' => $configId,
            'title' => $title,
            'subject' => $subject,
            'recipients' => json_encode(array_merge([$adminEmail => ''], $this->recipients->agency()),JSON_UNESCAPED_UNICODE),
            'body' => $this->view->fetch('mail.twig', $this->templateDataConverter->convertExt($form, $extendedData))
        ]);

        if($emails = $this->recipients->client()) {
            $stmt->execute([
                'config' => $configId,
                'title' => $title,
                'subject' => $subject,
                'recipients' => json_encode($this->recipients->client(), JSON_UNESCAPED_UNICODE),
                'body' => $this->view->fetch('mail.twig', $this->templateDataConverter->convert($form))
            ]);
        }
    }

    private function getConfigId() {

         $email = env('MAIL_EMAIL');
         $password = env('MAIL_PASSWORD');

        if(empty($email))
            throw new MailException('Email отправителя не задан!');

        if(empty($password))
            throw new MailException('Password отправителя не задан!');


        $stmt = $this->pdo->prepare("SELECT * FROM configs WHERE email=:email");
        $stmt->execute(['email' => $email]);

        if($config = $stmt->fetchObject()) {

            $emailPassword = $this->passwordHasher->decrypt($config->password);

            if($emailPassword != $password) {
                $stmt = $this->pdo->prepare("UPDATE configs SET password=:password WHERE id=:id");
                $stmt->execute([
                    'id' => $config->id,
                    'password' => $this->passwordHasher->encrypt($password)
                ]);
            }

        } else {
            $stmt = $this->pdo->prepare("INSERT INTO configs (email,password) VALUES (:email,:password)");
            $stmt->execute([
                'email' => $email,
                'password' => $this->passwordHasher->encrypt($password)
            ]);

            $stmt = $this->pdo->prepare("SELECT * FROM configs WHERE email=:email");
            $stmt->execute(['email' => $email]);

            $config = $stmt->fetchObject();
        }

        return $config->id;
    }
}