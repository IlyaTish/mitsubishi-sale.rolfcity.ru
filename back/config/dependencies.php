<?php

use Slim\App;
use Psr\Container\ContainerInterface;
use App\Http\Action;
use App\Model\Form;
use Slim\Views\Twig;
use App\Model\Parser;
use App\Core;

return function (App $app) {
    $container = $app->getContainer();

    // -----------------------------------------------------------------------------
    // Action factories
    // -----------------------------------------------------------------------------

    $container[Action\FormAction::class] = function (ContainerInterface $container) {
        $mail_handler = $container->get(Form\UseCase\Mail\Handler::class);
        $call_keeper_handler = $container->get(Form\UseCase\Callkeeper\Handler::class);
        $responseFactory = $container->get(\App\Http\Response\ResponseFactory::class);
        return new Action\FormAction($mail_handler, $call_keeper_handler, $responseFactory);
    };

    $container[Action\CarsAction::class] = function (ContainerInterface $container) {
        $storage = $container->get(Core\Storage\Storage::class);
        return new Action\CarsAction($storage);
    };

    $container[Action\CarsImgAction::class] = function (ContainerInterface $container) {
        $storage = $container->get(Core\Storage\Storage::class);
        return new Action\CarsImgAction($storage);
    };

    $container[Action\PingAction::class] = function (ContainerInterface $container) {
        $responseFactory = $container->get(\App\Http\Response\ResponseFactory::class);
        return new Action\PingAction($responseFactory);
    };

    // -----------------------------------------------------------------------------
    // Feed parser
    // -----------------------------------------------------------------------------

    $container[Parser\UseCase\FeedParser::class] = function (ContainerInterface $container) {
        $parserClass = $container->get('settings')['parser'];
        $imgSaver = $container->get(Parser\Service\ImgSaver::class);
        $storage = $container->get(Core\Storage\Storage::class);
        return new $parserClass($storage, $imgSaver);
    };

    // -----------------------------------------------------------------------------
    // Service providers
    // -----------------------------------------------------------------------------

    $container['logger'] = function (ContainerInterface $container) {
        $settings = $container->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    $container[Twig::class] = function (ContainerInterface $container) {
        $view = new Twig('../templates/');

        // Instantiate and add Slim specific extension
        $router = $container->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

        return $view;
    };

    $container[Core\Mailer\Mailer::class] = function (ContainerInterface $container) {

        $host = env('MAIL_HOST');
        $port = env('MAIL_PORT');
        $encryption = env('MAIL_ENCRYPTION');
        $email = env('MAIL_EMAIL');
        $password = env('MAIL_PASSWORD');
        $messageHelper = $container->get(Form\Service\MessageHelper::class);

        $transport = new Swift_SmtpTransport();

        $transport->setUsername($email)
            ->setPassword($password)
            ->setPort($port)
            ->setHost($host)
            ->setEncryption($encryption);

        $swiftMailer = new Swift_Mailer($transport);

        return new Core\Mailer\Mailer($swiftMailer, $messageHelper);
    };

    $container[Core\Storage\Storage::class] = function (ContainerInterface $container) {
        return new Core\Storage\Storage();
    };

    $container[\App\Http\Response\ResponseFactory::class] = function (ContainerInterface $container) {
        $displayErrors = env('DEBUG_MODE');
        return new \App\Http\Response\ResponseFactory($displayErrors);
    };

    // -----------------------------------------------------------------------------
    // Form module factories
    // -----------------------------------------------------------------------------

    $container[Form\UseCase\Mail\Handler::class] = function (ContainerInterface $container) {
        $mail_mode = getenv('MAIL_MODE');

        if($mail_mode == 'queue') {
            $mail_handler = $container->get(Form\UseCase\Mail\Queue\Handler::class);
        } else {
            $mail_handler = $container->get(Form\UseCase\Mail\Instant\Handler::class);
        }

        return $mail_handler;
    };

    $container[Form\UseCase\Mail\Instant\Handler::class] = function (ContainerInterface $container) {
        $mailer = $container->get(Core\Mailer\Mailer::class);
        $resipients = $container->get(Form\Service\Recipients::class);
        $temlateDataConverter = $container->get(Form\Service\TemplateDataConverter::class);
        $view = $container->get(Twig::class);
        return new Form\UseCase\Mail\Instant\Handler($mailer, $resipients, $view, $temlateDataConverter);
    };

    $container[Form\UseCase\Mail\Queue\Handler::class] = function (ContainerInterface $container) {
        $db = $container->get('mailer_db');
        $view = $container->get(Twig::class);
        $resipients = $container->get(Form\Service\Recipients::class);
        $temlateDataConverter = $container->get(Form\Service\TemplateDataConverter::class);
        $passwordHasher = $container->get(Form\Service\PasswordHasher::class);
        $messageHelper = $container->get(Form\Service\MessageHelper::class);
        return new Form\UseCase\Mail\Queue\Handler($db, $view, $resipients, $temlateDataConverter, $passwordHasher, $messageHelper);
    };

    $container['mailer_db'] = function (ContainerInterface $container) {
        $host = env('MAILER_HOST');
        $port = env('MAILER_PORT');
        $db   = env('MAILER_DB');
        $user = env('MAILER_USERNAME');
        $pass = env('MAILER_PASSWORD');
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";
        return new PDO($dsn,$user,$pass);
    };

    $container[Form\Service\MessageHelper::class] = function (ContainerInterface $container) {
        return new Form\Service\MessageHelper();
    };

    $container[Form\Service\Recipients::class] = function (ContainerInterface $container) {
        return new Form\Service\Recipients();
    };

    $container[Form\Service\TemplateDataConverter::class] = function (ContainerInterface $container) {
        return new Form\Service\TemplateDataConverter();
    };

    $container[Form\Service\PasswordHasher::class] = function (ContainerInterface $container) {
        return new Form\Service\PasswordHasher();
    };

    $container[Form\UseCase\Callkeeper\Handler::class] = function (ContainerInterface $container) {
        return new Form\UseCase\Callkeeper\Handler();
    };

    // -----------------------------------------------------------------------------
    // Parser factories
    // -----------------------------------------------------------------------------

    $container[Parser\Service\ImgSaver::class] = function (ContainerInterface $container) {
        $imgManager = new \Intervention\Image\ImageManager(array('driver' => 'imagick'));
        return new Parser\Service\ImgSaver($imgManager);
    };

    // -----------------------------------------------------------------------------
    // Error handlers
    // -----------------------------------------------------------------------------

    $container['errorHandler'] = function (ContainerInterface $container) {
        $mailer = $container->get(Core\Mailer\Mailer::class);
        $logger = $container->get('logger');
        $responseFactory = $container->get(\App\Http\Response\ResponseFactory::class);
        $view = $container->get(Twig::class);
        return new \App\Exception\Handler($mailer, $logger, $responseFactory, $view);
    };

    $container['phpErrorHandler'] = function (ContainerInterface $container) {
        $logger = $container->get('logger');
        $mailer = $container->get(Core\Mailer\Mailer::class);
        $responseFactory = $container->get(\App\Http\Response\ResponseFactory::class);
        $view = $container->get(Twig::class);
        return new \App\Exception\PhpHandler($mailer, $logger, $responseFactory, $view);
    };
};
