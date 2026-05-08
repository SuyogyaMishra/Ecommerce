<?php

namespace App\Validation;

class SignupValidation
{
    public static function rules()
    {
        return [

            'name' => [

                'rules' => 'required|min_length[3]|max_length[100]',

                'errors' => [

                    'required' => 'Full Name is required',

                    'min_length' => 'Name must be minimum 3 characters'
                ]
            ],

            'email' => [

                'rules' => 'required|valid_email|is_unique[users.email]',

                'errors' => [

                    'required' => 'Email is required',

                    'valid_email' => 'Enter valid email',

                    'is_unique' => 'Email already exists'
                ]
            ],

            'password' => [

                'rules' => 'required|min_length[6]',

                'errors' => [

                    'required' => 'Password is required',

                    'min_length' => 'Password minimum 6 characters'
                ]
            ],

            'confirm_password' => [

                'rules' => 'required|matches[password]',

                'errors' => [

                    'required' => 'Confirm Password required',

                    'matches' => 'Passwords do not match'
                ]
            ]
        ];
    }



    public static function loginRules()
    {
        return [

            'email' => [

                'rules' => 'required|valid_email',

                'errors' => [

                    'required' => 'Email is required',

                    'valid_email' => 'Enter valid email'
                ]
            ],

            'password' => [

                'rules' => 'required|min_length[6]',

                'errors' => [

                    'required' => 'Password is required',

                    'min_length' => 'Password minimum 6 characters'
                ]
            ]
        ];
    }
}