<?php

namespace App\Validation;

class ProductValidation
{
   
    public static function validate($request)
    {
        $validation = \Config\Services::validation();

        $rules = [

            'product_name' => [

                'rules' => 'required|min_length[3]|max_length[255]',

                'errors' => [

                    'required'   => 'Product name is required',

                    'min_length' => 'Product name must be at least 3 characters'

                ]

            ],

            'category' => [

                'rules' => 'required|min_length[3]',

                'errors' => [

                    'required' => 'Category is required'

                ]

            ],

            'price' => [

                'rules' => 'required|numeric|greater_than[500]',

                'errors' => [

                    'required' => 'Price is required',

                    'numeric'  => 'Price must be numeric'

                ]

            ],

            'quantity' => [

                'rules' => 'required|integer|greater_than[2]',

                'errors' => [

                    'required' => 'Quantity is required',

                    'integer'  => 'Quantity must be integer'

                ]

            ]

        ];

        $validation->setRules($rules);

        if (!$validation->withRequest($request)->run()) {

            return [

                'status' => false,

                'errors' => $validation->getErrors()

            ];
        }

        return [

            'status' => true

        ];
    }
}