<?php

namespace App\Services;

use App\Models\Payment;

class PaymentService
{

    public function __construct(


        public CoreService $core,


    ) {
    }


    public function pay()
    {




        $payment_status = 'paiding';
        if ($this->core->data['payment_type'] == 1) {

            $payment_status = 'paiding';
        }
        if ($this->core->data['payment_type'] == 2) {

            if ($this->core->data['paid'] == 0) {

                $payment_status = 'pendding';
            }
            if ($this->core->data['paid'] != 0 && $this->core->data['remaining'] != 0) {

                $payment_status = 'partially';
            }
        }


        $payment = new Payment();
        $payment->paymentable()->associate($this->core->paymentable);
        $payment->payment_info = $this->core->data['payment_type'];
        $payment->payment_status = $payment_status;
        $payment->paid = $this->core->data['paid'];
        $payment->remaining = $this->core->data['remaining'];
        $payment->save();

        return $this;
    }


    public function update()
    {

        $type = '';
        if ($this->core->data['type'] == 'PaymentBond') {

            $type = 'Purchase';
        }

        if ($this->core->data['type'] == 'ReceivableBond') {

            $type = 'Sale';
        }
        // dd($this->core->data['id'],$type);

        $payment = Payment::with(['Paymentable'])
            ->where('paymentable_type', 'App\\Models\\' . $type)
            ->where('paymentable_id', $this->core->data['id'])
            ->first();

        if ($payment) {

            $this->core->data['paid'] = $this->core->data['paid'] + $payment->paid;

            if ($this->core->data['remaining'] == 0) {
                $array_data = [
                    'payment_status' => 'paiding',
                    'paid' => $this->core->data['paid'],
                    'remaining' => $this->core->data['remaining']
                ];
            }
            if ($this->core->data['remaining'] > 0) {
                $array_data = [
                    'payment_status' => 'partialy',
                    'paid' => $this->core->data['paid'],
                    'remaining' => $this->core->data['remaining']
                ];
            }

            // dd($array_data);
            $payment->update($array_data);
        }




        return 1;

    }
}
