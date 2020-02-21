<?php


namespace App\Http\Response;

use Slim\Http\Response;

/**
 * Class ResponseFactory
 * @package App\Http\Response
 */
class ResponseFactory {

    /**
     * @var Response
     */
    private $response;
    /**
     * @var bool
     */
    private $displayErrors;

    /**
     * ResponseFactory constructor.
     * @param bool $displayErrors
     */
    public function __construct($displayErrors = false) {
        $this->response = new Response();
        $this->displayErrors = $displayErrors;
    }

    /**
     * @return Response
     */
    public function success() {
        return $this->response->withJson([
            'success' => true,
            'modules' => $this->modules()
        ]);
    }

    /**
     * @param $status
     * @param $error
     * @param array $desc
     * @return Response
     */
    public function error($status, $error, $desc = []) {

        $responseArray = [
            'success' => false,
            'modules' => $this->modules()
        ];

        if($this->displayErrors) {
            $responseArray['error'] = $error;
            if(!empty($desc)) $responseArray['desc'] = $desc;
        }

        return $this->response->withStatus($status)->withJson($responseArray);
    }

    public function info() {
        return $this->response->withJson([
            'url' => env('URL'),
            'modules' => $this->modules()
        ]);
    }


    /**
     * @return array
     */
    private function modules() {
        $modules = [
            'mailer' => env('MAIL_MODE'),
            'ck_api' => env('CK_ENABLE')
        ];
        return $modules;
    }
}