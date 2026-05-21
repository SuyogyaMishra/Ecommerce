<?php
namespace App\Services\Payments\Taxes;
 
use App\Interfaces\TaxInterface;

class shipingTaxService implements  TaxInterface{
     
    public function calculate($amount){
              
              (int) $shipingTax= $amount* 10/100;
               return [
                   'taxname'=>'Shipping Tax',
                   'taxamount'=>$shipingTax
               ];

    }

} 