<?php

namespace App\Validation;

class OrderValidation extends BaseValidation{

    public function validateOrder(){

        return $this->validateData(

            [

                'name'=>'required|min_length[3]|max_length[100]',

                'email'=>'required|valid_email|max_length[150]',

                'phone'=>'required|numeric|min_length[10]|max_length[15]',

                'address'=>'required|min_length[10]|max_length[500]',

                'payment_method'=>'required|in_list[cod,online]'

            ],

            [

                'name'=>[

                    'required'=>'Full name is required',

                    'min_length'=>'Name must be at least 3 characters'

                ],

                'email'=>[

                    'required'=>'Email is required',

                    'valid_email'=>'Enter valid email address'

                ],

                'phone'=>[

                    'required'=>'Phone number is required',

                    'numeric'=>'Phone must contain only numbers',

                    'min_length'=>'Phone number must be at least 10 digits'

                ],

                'address'=>[

                    'required'=>'Address is required',

                    'min_length'=>'Address must be at least 10 characters'

                ],

                'payment_method'=>[

                    'required'=>'Payment method is required',

                    'in_list'=>'Invalid payment method selected'

                ]

            ]

        );
    }
}