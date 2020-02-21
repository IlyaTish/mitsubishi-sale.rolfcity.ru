<?php


namespace App\Exception;


use Throwable;

class MailException extends \Exception {

    public function __construct($message, $code = 500, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}