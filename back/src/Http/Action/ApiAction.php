<?php


namespace App\Http\Action;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class ApiAction
 * @package App\Http\Action
 */
abstract class ApiAction {

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, $args) {
        return $this->handle($request, $response, $args);
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     */
    abstract public function handle(Request $request, Response $response, $args);
}