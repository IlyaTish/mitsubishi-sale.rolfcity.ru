<?php


namespace App\Exception;

use App\Core\Mailer\Mailer;
use App\Http\Response\ResponseFactory;
use \Exception;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\StatusCode;
use Slim\Views\Twig;

class Handler {

    protected $mailer;
    protected $logger;
    protected $responseFactory;
    protected $view;

    /**
     * @param Mailer $mailer
     * @param Logger $logger
     * @param ResponseFactory $responseFactory
     * @param Twig $view
     */
    public function __construct(Mailer $mailer,Logger $logger, ResponseFactory $responseFactory, Twig $view) {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->responseFactory = $responseFactory;
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Exception $exception) {

        $error_notify = env('ERROR_NOTIFY');

        $code = $this->isHttpCode($exception->getCode())  ? $exception->getCode() : 500;
        $error = $exception->getMessage();
        $context = [
            'Запрос' => $request->getParsedBody()
        ];

        if($exception instanceof BaseException)
            $context['Описание'] = $exception->getMessageBag();

        switch ($exception) {
            case $exception instanceof ValidateException:
            case $exception instanceof CallKeeperApiException:
                $response = $this->responseFactory->error($code, $exception->getMessage(), $exception->getMessageBag());
                break;
            default:
                $response = $this->responseFactory->error($code, $exception->getMessage());
        }

        $this->logger->addError($error, $context);

        if($error_notify) {
            $this->mailer->sendError(
                $this->view->fetch('error.twig', [
                    'error' => $error,
                    'context' => $context
                ])
            );
        }

        return $response;
    }

    private function isHttpCode($code) {
        $class = new \ReflectionClass(new StatusCode());
        return in_array($code, $class->getConstants());
    }
}