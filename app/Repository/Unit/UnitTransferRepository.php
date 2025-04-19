<?php

namespace App\Repository\Unit;

use App\RepositoryInterface\UnitRepositoryInterface;
use App\Services\CoreService;
class UnitTransferRepository  implements UnitRepositoryInterface
{


    public $core;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    public function handle_unit(){

        $this->encoed_unit();
        $this->convert_unit();
    }

    public function encoed_unit()
    {

        $this->core->unit_array = $this->core->data['unit'][$this->core->value];
        // dd($this->core->data);
        return $this;

    }


    function convert_unit()
    {



        
        
        foreach ($this->core->data['old'][$this->core->value]['units'] as  $value) {

            // dd($this->core->data['qty_transfer'][$this->core->value] , $this->core->unit_array[1]);
            $this->core->micro_unit_qty = $this->core->data['qty_transfer'][$this->core->value] *$this->core->unit_array[1];

            // if ($value['unit_id'] == $this->core->unit_array[0]) {  //this means unit_type


            //     $this->core->micro_unit_qty = ($this->core->data['qty_transfer'][$this->core->value] * $value['rate']);

            // }
    
        }


        return $this;
        
    }




    
 
}
