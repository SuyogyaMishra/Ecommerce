<?php

namespace App\Core\Kyc;

abstract class KycVerification
{
    protected array $docs = [];
    protected array $errors = [];

    public function addDocs(array $documents)
    {
        foreach ($documents as $name => $number) {
            $this->docs[$name] = $number;
        }

        return $this;
    }

    public function validate()
    {
        foreach ($this->docs as $name => $number) {

            switch ($name) {

                case 'aadhaar':
                    if (empty($number)) {
                        $this->errors['document_number'] = 'Aadhaar number is required';
                    } elseif (!preg_match('/^[0-9]{12}$/', $number)) {
                        $this->errors['document_number'] = 'Invalid Aadhaar number';
                    }
                    break;

                default:
                    $this->errors[] = $name." is not supported";
            }
        }

        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

}