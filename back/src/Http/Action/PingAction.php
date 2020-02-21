<?php

namespace App\Http\Action;

use App\Http\Response\ResponseFactory;
use Slim\Http\Request;
use Slim\Http\Response;

class PingAction extends ApiAction {

    private $responseFactory;

    public function __construct(ResponseFactory $responseFactory) {
        $this->responseFactory = $responseFactory;
    }

    public function handle(Request $request, Response $response, $args) {
        return $this->responseFactory->info();
    }
}