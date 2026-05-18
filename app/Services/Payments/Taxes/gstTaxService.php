<?php
namespace App\Services\Payments\Taxes;
 
use App\Interfaces\TaxInterface;

class gstTaxService implements  TaxInterface{
     
    public function calculate($amount){
              
              (int) $Tax= $amount* 5/100;
               return [
                   'taxname'=>'Gst',
                   'taxamount'=>$Tax
               ];

    }

} 