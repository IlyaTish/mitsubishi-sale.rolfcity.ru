<?php


namespace App\Exception;

use Throwable;

class ValidateException extends BaseException {

    public function __construct($message, $messageBag = [], $code = 400, Throwable $previous = null) {
        parent::__construct($message, $messageBag, $code, $previous);
    }
}