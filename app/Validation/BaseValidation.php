<?php

namespace App\Validation;

class BaseValidation
{

    protected $validation;
    protected $request;

    public function __construct()
    {
        $this->validation = service('validation');
        $this->request = service('request');
    }

    protected function validateData($rules, $messages = [], $data = [])
    {

        $data = $data ?: $this->request->getPost();

        $this->validation->setRules($rules, $messages);

        if (!$this->validation->run($data))
            return [
                'status' => false,
                'errors' => $this->validation->getErrors(),
                'message' => $this->firstError(
                    $this->validation->getErrors()
                )
            ];

        return [
            'status' => true,
            'data' => $data
        ];
    }

    protected function validateJson($rules, $messages = [])
    {

        $data = $this->request->getJSON(true) ?? [];

        return $this->validateData($rules, $messages, $data);
    }

    protected function validateFiles($rules, $messages = [])
    {

        $this->validation->setRules($rules, $messages);

        if (!$this->validation
            ->withRequest($this->request)
            ->run())
            return [
                'status' => false,
                'errors' => $this->validation->getErrors(),
                'message' => $this->firstError(
                    $this->validation->getErrors()
                )
            ];

        return [
            'status' => true,
            'data' => $this->request->getPost(),
            'files' => $this->request->getFiles()
        ];
    }

    protected function firstError($errors)
    {
        return array_values($errors)[0] ?? null;
    }
}
