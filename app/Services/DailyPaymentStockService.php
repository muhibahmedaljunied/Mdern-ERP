<?php

namespace App\Services;

use App\Models\Advance;
use App\Models\Allowance;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Extra;
use App\Models\Payroll;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Treasury;

class DailyPaymentStockService
{
    public $core;

    public function __construct()
    {
        $this->core = app(CoreStaffService::class);
    }


    // public function get_extra()
    // {




    //     if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

    //         $this->core->account_details = Extra::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
    //     } else {

    //         $this->core->account_details = Extra::find($this->core->data[$this->core->daily_type]['account_details']);
    //     }
    // }



    public function get_allowance()
    {

        if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

            $this->core->account_details = Allowance::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
        } else {

            $this->core->account_details = Allowance::find($this->core->data[$this->core->daily_type]['account_details']);
        }
    }

    public function get_payroll()
    {


        if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

            $this->core->account_details = Payroll::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
        } else {

            $this->core->account_details = Payroll::find($this->core->data[$this->core->daily_type]['account_details']);
        }
    }


    public function get_advance()
    {

        if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

            $this->core->account_details = Advance::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
        } else {

            $this->core->account_details = Advance::find($this->core->data[$this->core->daily_type]['account_details']);
        }
    }


    public function get_treasury()
    {

        if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

            $this->core->account_details = Treasury::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
        } else {

            $this->core->account_details = Treasury::find($this->core->data[$this->core->daily_type]['account_details']);
        }
    }


    public function get_bank()
    {

        if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

            $this->core->account_details = Bank::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
        } else {

            $this->core->account_details = Bank::find($this->core->data[$this->core->daily_type]['account_details']);
        }
    }
    public function get_supplier()
    {


        if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

            $this->core->account_details = Supplier::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
        } else {

            $this->core->account_details = Supplier::find($this->core->data[$this->core->daily_type]['account_details']);
        }
    }


    public function get_customer()
    {



        if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

            $this->core->account_details = Customer::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
        } else {

            $this->core->account_details = Customer::find($this->core->data[$this->core->daily_type]['account_details']);
        }
    }

    public function get_store()
    {




        if (gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array') {

            $this->core->account_details = Store::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
        } else {

            $this->core->account_details = Store::find($this->core->data[$this->core->daily_type]['account_details']);
        }
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

        if ($this->core->data['type_daily'] == 'hr_all_prove_salary') {

            $this->get_payroll();

            // dd($this->core->account_details);
        }

        // -----------------------------------------------------------------------------------------------------------

        if ($this->core->data['type_daily'] == 'hr_advance') {

            $this->get_advance();
        }

        // -----------------------------------------------------------------------------------------------------------


        if ($this->core->data['type_daily'] == 'PaymentBond') {

            $this->get_supplier();
        }
        // -----------------------------------------------------------------------------------------------------------


        if (
            $this->core->data['type_daily'] == 'purchase' ||
            $this->core->data['type_daily'] == 'supply'

        ) {

            $this->get_store();
        }
        // -----------------------------------------------------------------------------------------------------------

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



        // if ($this->core->data['type_daily'] == 'hr_extra') {

        //     $this->get_extra();
        // }
        // -----------------------------------------------------------------------------------------------------------


        if ($this->core->data['type_daily'] == 'ReceivableBond') {

            $this->get_customer();
        }
        // -----------------------------------------------------------------------------------------------------------


        if ($this->core->data['type_daily'] == 'hr_all_prove_salary') {

            $this->get_payroll();

            dd($this->core->account_details);
        }


        // -----------------------------------------------------------------------------------------------------------

        if (
            $this->core->data['type_daily'] == 'purchase' ||
            $this->core->data['type_daily'] == 'supply' ||
            $this->core->data['type_daily'] == 'PaymentBond' ||
            $this->core->data['type_daily'] == 'hr_advance'


        ) {

            $this->choice_account_with_payment();
        }
        // -----------------------------------------------------------------------------------------------------------

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

            if (
                $this->core->data['type_daily'] == 'sale' ||
                $this->core->data['type_daily'] == 'cash' ||
                $this->core->data['type_daily'] == 'ReceivableBond'
            ) {

                $this->get_customer();
            }

            if (
                $this->core->data['type_daily'] == 'purchase' ||
                $this->core->data['type_daily'] == 'supply' ||
                $this->core->data['type_daily'] == 'PaymentBond'
            ) {

                $this->get_supplier();
            }
        }
    }
}
