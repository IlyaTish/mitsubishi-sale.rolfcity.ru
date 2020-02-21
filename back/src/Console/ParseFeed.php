<?php

namespace App\Console;

use App\Model\Parser\UseCase\AvtomirFeedParser;
use App\Model\Parser\UseCase\FeedParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseFeed extends Command {

    private $parser;

    public function __construct(FeedParser $parser, $name = null) {
        parent::__construct($name);
        $this->parser = $parser;
    }

    protected function configure() {
        $this
            ->setName('parse:feed')
            ->setDescription('Cars feed parser');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->parser->handle();
    }
}