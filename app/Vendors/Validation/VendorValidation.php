<?php

namespace App\Vendors\Validation;

use App\Core\Validation\BaseValidation;

class VendorValidation extends BaseValidation
{

    public function validateVendor()
    {

        return $this->validateData(

            [

                'name' => 'required|min_length[3]|max_length[100]',

                'email' => 'required|valid_email|',

                'phone' => 'required|numeric|min_length[10]|max_length[10]',
               
                'address' =>'required|min_length[5]|max_length[255]',
               


            ],

            [

                'name' => [

                    'required' => 'Full Name is required',

                    'min_length' => 'Name must be minimum 3 characters',

                    'max_length' => 'Name maximum 100 characters'

                ],

                'email' => [

                    'required' => 'Email is required',

                    'valid_email' => 'Enter valid email',

                ],


            ]

        );
    }
}
