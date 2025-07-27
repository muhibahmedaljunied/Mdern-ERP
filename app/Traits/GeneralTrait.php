<?php

namespace App\Traits;

use App\Traits\ConditionTrait;
use App\Traits\Details\DetailsTrait;
use App\Traits\Return\ReturnTrait;
use App\Models\PaymentPurchase;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\Transfer\StoreProductTrait;
use App\Traits\Unit\UnitsTrait;

trait GeneralTrait
{
    use ConditionTrait,
        DetailsTrait,
        ReturnTrait,
        OperationDataTrait,
        InvoiceTrait,
        ProductPriceTrait,
        StoreProductTrait,
        UnitsTrait;



    public function pay($data, $id)
    {

        $payment_status = 'pendding';
        $payment_info = $data['type'];
        if ($data['paid'] == 0) {
            $payment_status = 'pendding';
        }
        if ($data['paid'] != 0 && $data['remaining'] != 0) {
            $payment_status = 'Partially';
        }
        ($data['remaining'] == 1) ? $payment_info = $data['type'] : $payment_info = 'credit';
        $payment_status = 'paiding';
        // -----------------------------------------------------------------------------------------
        $payment = ($data['type'] == 'Purchase') ? $this->payment_purchase() : $this->payment_sale();

        $payment = new PaymentPurchase();
        $payment->purchase_id = $id;
        $payment->payment_info = $payment_info;
        $payment->payment_status = $payment_status;
        $payment->paid = $data['paid'];
        $payment->remaining = $data['remaining'];
        $payment->save();
        return $payment->id;
    }



    // OperationDataTrait انا غيرت اسمه  لانه يتعارض  مع function _unit_  اذا كنت تستعمله غي مكان اخر
    // قم بتغير اسم احداهما في باقي الاماكن التي تستدعيه فيه

    public function _unit_($data, $value)   //function unit
    {



        foreach ($data as $key => $values) {   //this for converts qty_avaliable into big unit

            $micro_unit_qty = $data['qty'];

            if ($values['units']['name'] == $values['unit'] && $values['units']['unit_type'] == 1) {


                $micro_unit_qty = $data['qty'] * $data['unit_id'][1];
            }

            if ($values['units']['name'] == $values['unit'] && $values['units']['unit_type'] == 0) {


                $micro_unit_qty = $data['qty'];
            }
        }

        return $micro_unit_qty;
    }
}
