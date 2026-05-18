<?php
namespace App\Factories;
use App\Factories\BaseFactory;
use App\Services\Payments\Taxes\shipingTaxService;
use App\Services\Payments\Taxes\gstTaxService;

class TaxFactory extends BaseFactory{
      
      protected static array $items=[
        
         'shiping' =>shipingTaxService::class,
         'gst'=>gstTaxService::class
      
    ];
     
}