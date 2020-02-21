<?php


namespace App\Exception;

use Throwable;

class CallKeeperApiException extends BaseException {

    public function __construct($message, $messageBag = [], $code = 500, Throwable $previous = null) {
        parent::__construct($message, $messageBag, $code, $previous);
    }
}
