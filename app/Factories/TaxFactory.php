<?php
namespace App\Factories;
use App\Factories\BaseFactory;
use App\Services\Payments\Taxes\shipingTaxService;

class TaxFactory extends BaseFactory{
      
      protected static array $items=[
        
         'shiping' =>shipingTaxService::class
      
    ];
     
}