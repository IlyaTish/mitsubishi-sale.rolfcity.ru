<?php

use Slim\App;
use App\Http\Action;

return function (App $app) {
    $app->post('/send', Action\FormAction::class);
    $app->get('/cars', Action\CarsAction::class);
    $app->get('/image/{vin}', Action\CarsImgAction::class);
    $app->get('/ping', Action\PingAction::class);
};
