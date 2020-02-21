<?php

namespace App\Http\Action;

use App\Core\Storage\Storage;
use Slim\Http\Request;
use Slim\Http\Response;

class CarsAction extends ApiAction {

    /**
     * @var Storage
     */
    private $storage;

    /**
     * FeedParser constructor.
     * @param Storage $storage
     */
    public function __construct(Storage $storage) {
        $this->storage = $storage;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     */
    public function handle(Request $request, Response $response, $args) {
        return $response->withJson(json_decode($this->storage->get('parser/feed.json'), true));
    }
}