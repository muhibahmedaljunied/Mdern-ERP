<?php

namespace App\Repository\CheckData;

use App\Services\CoreService;

class CheckSaleReturnRepository

{

    public $error;
    public $core;
    public $qty_return_now;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    public function check_return($value)
    {


        $this->qty_return_now = intval($this->core->data['qty'][$value]) * $this->core->data['unit'][$value][1];
        $this->message($value);

        if ($this->error != 0) {

            return $this->error;
        }

        return [
            'status' => 1,
            'qty' => $this->qty_return_now
        ];
    }



    public function message($value)
    {

        $this->error = 0;

        if ($this->qty_return_now > $this->core->data['old'][$value]['qty_remain']) {

            $this->error =  ['status' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المسموح بها"];
        }

        if ($this->qty_return_now > $this->core->data['old'][$value]['qty']) {

            $this->error =  ['status' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  كميه البيع الفعليه"];
        }

        if ($this->core->data['old'][$value]['qty_remain'] == 0) {

            $this->error =  ['status' => 0, 'text' => "لا يمكنك ارجاع اي كميه لقد ارجعت  الكميه كامله"];
        }

        if ($this->qty_return_now == 0) {

            $this->error =  ['status' => 0, 'text' => "لا يمكنك ارجاع كميه 0"];
        }
    }
}
