<?php

namespace App\Http\Action;

use App\Core\Storage\Storage;
use Slim\Http\Request;
use Slim\Http\Response;

class CarsImgAction extends ApiAction {

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
        $image = $this->storage->get('parser/image/' . $args['vin'] . '.png');
        $response->write($image);
        return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE);
    }
}