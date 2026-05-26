<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Core\Libraries\Logger;

class BaseService{

    protected $response,$request,$user,$db,$logger;
    public function __construct(){

        $this->response=service('response');
        $this->request=service('request');
        $this->db=\Config\Database::connect();
        $this->user=UserRepository::user();
        $this->logger =  Logger::getInstance();

    }
    protected function json(
        $status=true,
        $message='Success',
        $data=[],
        $code=200
    ){

        return $this->response
            ->setStatusCode($code)
            ->setJSON(

                array_merge([

                    'status'=>$status,

                    'message'=>$message,

                ],$data)

            );
    }

    protected function success(
        $message='Success',
        $data=[],
        $code=200
    ){

        return $this->json(
            true,
            $message,
            $data,
            $code
        );
    }

    protected function error(
        $message='Something went wrong',
        $errors=[],
        $code=400
    ){

        return $this->json(

            false,

            $message,

            [

                'errors'=>$errors

            ],

            $code
        );
    }

    protected function validationError($errors=[]
    ){

        return $this->json(

            false,

            array_values($errors)[0]
            ?? 'Validation failed',

            [

                'errors'=>$errors

            ],

            422
        );
    }
  
}