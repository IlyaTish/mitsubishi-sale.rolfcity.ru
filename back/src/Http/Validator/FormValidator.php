<?php


namespace App\Http\Validator;

use App\Model\Form\UseCase\Form;
use Valitron\Validator;

/**
 * Class FormValidator
 * @package App\Http\Validator
 */
class FormValidator {

    /**
     * @var Form
     */
    private $form;
    private $errors = [];

    /**
     * FormValidator constructor.
     * @param Form $form
     */
    private function __construct(Form $form) {
        $this->form = $form;
    }

    /**
     * @param Form $form
     * @return FormValidator
     */
    public static function make(Form $form) {
        return new self($form);
    }

    /**
     * @return $this
     */
    public function validate() {
        $validator = new Validator(call_user_func('get_object_vars', $this->form), [], 'ru');
        $validator->rules([
            'required' => ['url', 'phone', 'type', 'path'],
            'url' => ['url'],
            'regex' => [
                ['phone', '/^((8|\+7|7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7}$/']
            ],
            'integer' => ['type'],
            'in' => [
                ['type',  [0,1,2,3,4]],
                ['debug', [0,1]],
            ]
        ]);

        $validator->validate();
        $errors = $validator->errors();

        $env_host = env('URL');
        if(!$this->form ->url || strpos($env_host, $this->form->url) !== 0) $errors['url'][] = 'Url недействителен';

        $this->errors = $errors;
        return $this;
    }

    /**
     * @return array
     */
    public function errors() {
        return $this->errors;
    }
}