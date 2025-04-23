<?php

namespace App\Repository\Unit;

use App\RepositoryInterface\UnitRepositoryInterface;
use App\Services\CoreService;

class UnitDecodeRepository  implements UnitRepositoryInterface
{


    public $core;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    public function handle_unit()
    {

        $this->decode_unit();
        $this->convert_unit();
    }

    public function decode_unit()
    {



        // $this->core->unit_array = json_decode($this->core->data['unit'][$this->core->value]);
        $this->core->unit_array = $this->core->data['unit'][$this->core->value];



        // dd($this->core->unit_array);
        return $this;
    }

    function convert_unit()
    {


        // dd($this->core->unit_array[1], $this->core->data['qty'][$this->core->value]);

        $this->core->micro_unit_qty = $this->core->unit_array[1] * $this->core->data['qty'][$this->core->value];


        // foreach ($this->core->data['units'] as  $value) {


        //     if ($value['unit_id'] == $this->core->unit_array[0]) {  //this means unit_type

        //         $this->core->micro_unit_qty = ($this->core->data['qty'][$this->core->value] * $value['rate']);
        //         // $this->core->micro_unit_qty = ($this->core->data['qty'][$this->core->value]);
        //     }
        // }

        return $this;
    }
}
