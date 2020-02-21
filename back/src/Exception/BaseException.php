<?php


namespace App\Exception;

use Throwable;

/**
 * Class BaseException
 * @package App\Exception
 */
abstract class BaseException extends \Exception {

    protected $messageBag;

    /**
     * BaseException constructor.
     * @param $message
     * @param array $messageBag
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $messageBag = [], $code = 400, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->messageBag = $messageBag;
    }

    /**
     * @return array
     */
    public function getMessageBag() {
        return $this->messageBag;
    }
}