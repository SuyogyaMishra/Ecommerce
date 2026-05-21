<?php

namespace App\Services;

use App\Repositories\UserRepository;

class BaseService{

    protected $response,$request,$user,$db;
    public function __construct(){

        $this->response=service('response');
        $this->request=service('request');
        $this->db=\Config\Database::connect();
        $this->user=UserRepository::user();

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

                    'token'=>csrf_hash()

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

    protected function unauthorized(
        $message='Unauthorized'
    ){

        return $this->json(
            false,
            $message,
            [],
            401
        );
    }

    protected function forbidden(
        $message='Forbidden'
    ){

        return $this->json(
            false,
            $message,
            [],
            403
        );
    }

    protected function notFound(
        $message='Not found'
    ){

        return $this->json(
            false,
            $message,
            [],
            404
        );
    }

    protected function serverError(
        $message='Internal server error'
    ){

        return $this->json(
            false,
            $message,
            [],
            500
        );
    }
  
}