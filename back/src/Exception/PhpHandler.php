<?php


namespace App\Exception;

use App\Core\Mailer\Mailer;
use App\Http\Response\ResponseFactory;
use Error;
use Exception;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\StatusCode;
use Slim\Views\Twig;

class PhpHandler {

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

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Error $error) {

        $context = [
            'file' => $error->getFile(),
            'line' => $error->getLine()
        ];
        $this->logger->addError($error->getMessage(), $context);


        if(env('ERROR_NOTIFY')) {
            $this->mailer->sendError(
                $this->view->fetch('error.twig', [
                    'error' => $error->getMessage(),
                    'context' => $context
                ])
            );
        }

        return $this->responseFactory->error(500, $error->getMessage(), $context);
    }
}