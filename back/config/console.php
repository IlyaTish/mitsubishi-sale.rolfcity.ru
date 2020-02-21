<?php


use Symfony\Component\Console\Application;
use Psr\Container\ContainerInterface;
use App\Console\ParseFeed;
use App\Model\Parser\UseCase\FeedParser;

return function (Application $app, ContainerInterface $container) {

    $app->add(
        new ParseFeed(
            $container->get(FeedParser::class)
        )
    );
};