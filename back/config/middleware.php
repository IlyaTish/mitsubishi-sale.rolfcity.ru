<?php

use Slim\App;
use App\Http\Middleware;

return function (App $app) {
    $app->add(new Middleware\TrailingSlash());
};
