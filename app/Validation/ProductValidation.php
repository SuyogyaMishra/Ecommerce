<?php

namespace App\Validation;

class ProductValidation extends BaseValidation{

    public function validateProduct(){

        return $this->validateFiles(

            [

                'name'=>'required|min_length[3]|max_length[255]',

                'price'=>'required|numeric|greater_than[0]',

                'stock'=>'required|integer|greater_than_equal_to[0]',

                'status'=>'required|in_list[0,1]',

                'image'=>'is_image[image]|max_size[image,2048]'

            ],

            [

                'name'=>[

                    'required'=>'Product name is required',

                    'min_length'=>'Product name must be at least 3 characters'

                ],

                'price'=>[

                    'required'=>'Price is required',

                    'numeric'=>'Price must be numeric'

                ],

                'stock'=>[

                    'required'=>'Stock is required',

                    'integer'=>'Stock must be integer'

                ],

                'status'=>[

                    'required'=>'Status is required'

                ],

                'image'=>[

                    'is_image'=>'Only image files allowed',

                    'max_size'=>'Image size must be less than 2MB'

                ]

            ]

        );
    }
}