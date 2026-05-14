<?php

use App\Repositories\UserRepository;

if (!function_exists('successResponse')) {

    function successResponse($data=[], $message='Success', $code=200) {

        return service('response')
            ->setStatusCode($code)
            ->setJSON([
                'status' => true,
                'message' => $message,
                'user' => $data
            ]);
    }
}

if (!function_exists('errorResponse')) {

    function errorResponse($message='Error', $code=400) {

        return service('response')
            ->setStatusCode($code)
            ->setJSON([
                'status' => false,
                'message' => $message
            ]);
    }
if (!function_exists('successResponseArray')) {
    function successResponseArray($message='Success', $code=200, $data=[]) {

    return service('response')
        ->setStatusCode($code)
        ->setJSON(array_merge([
            'status' => $code,
            'message' => $message
        ], $data));
}



}
}