<?php

namespace App\Services;

use App\Models\Advance;
use App\Models\Allowance;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Treasury;
class DailyCreditService
{
    public $core;

    public function __construct()
    {
        $this->core = app(CoreStaffService::class);
    }

    public function check_payment_type()
    {


     

        if ($this->core->daily_type == 'debit') {


            $this->debit();
        }


        if ($this->core->daily_type == 'credit') {

            $this->credit();
        }
    }


    public function debit()
    {



        if ($this->core->data['type_daily'] == 'hr_allowance') {

            $this->get_allowance();
        }

        if ($this->core->data['type_daily'] == 'hr_advance') {

            $this->get_advance();
        }

      

        if ($this->core->data['type_daily'] == 'PaymentBond') {

            $this->get_supplier();
        }


        if (
            $this->core->data['type_daily'] == 'purchase' ||
            $this->core->data['type_daily'] == 'supply'

        ) {

            $this->get_store();
        }

        if (
            $this->core->data['type_daily'] == 'sale' ||
            $this->core->data['type_daily'] == 'cash' ||
            $this->core->data['type_daily'] == 'income_expence' ||
            $this->core->data['type_daily'] == 'ReceivableBond'


        ) {

            $this->choice_account_with_payment();
        }
    }



    public function credit()
    {



        if ($this->core->data['type_daily'] == 'ReceivableBond') {

            $this->get_customer();
        }

       
        if (
            $this->core->data['type_daily'] == 'purchase' ||
            $this->core->data['type_daily'] == 'supply' ||
            $this->core->data['type_daily'] == 'PaymentBond' ||
            $this->core->data['type_daily'] == 'hr_advance'


        ) {

            $this->choice_account_with_payment();
        }

        if (
            $this->core->data['type_daily'] == 'sale' ||
            $this->core->data['type_daily'] == 'cash' ||
            $this->core->data['type_daily'] == 'income_expence'

        ) {

            $this->get_store();
        }
    }

    public function choice_account_with_payment()
    {


        if ($this->core->data['payment_type'] == 1) {

            $this->get_treasury();
        }
        if ($this->core->data['payment_type'] == 3) {

            $this->get_bank();
        }

        if ($this->core->data['payment_type'] == 2) {

            if ($this->core->data['type_daily'] == 'sale' || $this->core->data['type_daily'] == 'cash' || $this->core->data['type_daily'] == 'ReceivableBond') {

                $this->get_customer();
            }

            if ($this->core->data['type_daily'] == 'purchase' || $this->core->data['type_daily'] == 'supply' || $this->core->data['type_daily'] == 'PaymentBond') {

                $this->get_supplier();
            }
        }
    }
}
