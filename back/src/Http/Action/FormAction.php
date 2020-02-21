<?php

namespace App\Http\Action;

use App\Exception\ValidateException;
use App\Http\Response\ResponseFactory;
use App\Http\Validator\FormValidator;
use App\Model\Form\UseCase\Form;
use App\Model\Form\UseCase\Mail;
use App\Model\Form\UseCase\Callkeeper;
use Slim\Http\Request;
use Slim\Http\Response;

class FormAction extends ApiAction {

    private $mail;
    private $callKeeper;
    private $responseFactory;

    public function __construct(Mail\Handler $mail, Callkeeper\Handler $callKeeper, ResponseFactory $responseFactory) {
        $this->mail = $mail;
        $this->callKeeper = $callKeeper;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     */
    public function handle(Request $request, Response $response, $args) {

        $ip = ip();
        $userAgent = $request->getHeaderLine('User-Agent');

        $form = Form::create($request->getParsedBody(), $ip, $userAgent);
        $validator = FormValidator::make($form)->validate();

        if(count($validator->errors()) > 0) {
           throw new ValidateException( 'Ошибка валидации', $validator->errors());
        }

        if(!$form->debug) {
            $call_keeper_enable = env('CK_ENABLE');
            if($call_keeper_enable) {
                $call_keeper_response = $this->callKeeper->handle($form);
                $this->mail->handle($form, $call_keeper_response);
            } else {
                $this->mail->handle($form);
            }
        }

        return $this->responseFactory->success();
    }
}