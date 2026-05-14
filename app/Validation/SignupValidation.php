<?php

namespace App\Validation;

class SignupValidation extends BaseValidation{

    public function validateSignup(){

        return $this->validateData(

            [

                'name'=>'required|min_length[3]|max_length[100]',

                'email'=>'required|valid_email|is_unique[users.email]',

                'password'=>'required|min_length[6]',

                'confirm_password'=>'required|matches[password]'

            ],

            [

                'name'=>[

                    'required'=>'Full Name is required',

                    'min_length'=>'Name must be minimum 3 characters',

                    'max_length'=>'Name maximum 100 characters'

                ],

                'email'=>[

                    'required'=>'Email is required',

                    'valid_email'=>'Enter valid email',

                    'is_unique'=>'Email already exists'

                ],

                'password'=>[

                    'required'=>'Password is required',

                    'min_length'=>'Password minimum 6 characters'

                ],

                'confirm_password'=>[

                    'required'=>'Confirm Password required',

                    'matches'=>'Passwords do not match'

                ]

            ]

        );
    }

    public function validateLogin(){

        return $this->validateData(

            [

                'email'=>'required|valid_email',

                'password'=>'required|min_length[6]'

            ],

            [

                'email'=>[

                    'required'=>'Email is required',

                    'valid_email'=>'Enter valid email'

                ],

                'password'=>[

                    'required'=>'Password is required',

                    'min_length'=>'Password minimum 6 characters'

                ]

            ]

        );
    }
}