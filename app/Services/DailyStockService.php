<?php

namespace App\Services;

use App\Models\Daily;
use App\Models\DailyDetail;
use App\Models\GroupAccountDailyDetail;

class DailyStockService
{


    public $core;
    public function __construct(public DailyPaymentStockService $daily_payment)
    {

        $this->daily_payment = $daily_payment;
        $this->core = $this->daily_payment->core;
    }


    public function init_items($type)
    {



        $this->core->daily_type = $type;

        // dd($this->core->data[$this->core->daily_type]);
        $this->core->value = $this->core->data[$this->core->daily_type]['value'];

        $this->core->dailyDetailId_item =  [
            'daily_id' => '',
            'account_id' => '',
            'description' => '',
            'debit' => 0,
            'credit' => 0
        ];
    }
    public function detect_number_daily()
    {
        // dd(gettype($this->core->value));


        if (gettype($this->core->value) == 'string' || gettype($this->core->value) == 'integer') {


            $this->one_daily();
        }


        if (gettype($this->core->value) == 'array') {

            $this->multble_daily();
        }
    }
    public function daily()
    {



        $daily = new Daily();
        $daily->daily_date = $this->core->data['date'];
        $daily->total = $this->core->data['grand_total'];
        $daily->save();

        $this->core->daily_id = $daily->id;






        return $this;
    }




    public function one_daily()
    {

        $this->core->set_row_daily_details(0);
        $this->set_daily_value();
        $this->data_daily_detail();


        if (array_key_exists('account_details', $this->core->data[$this->core->daily_type])) {
            // $this->detect_number_daily_detail();

            $this->set_account_details();
        }

        // dd(122);
    }
    public function multble_daily()
    {


        // dd(count($this->core->data[$this->core->daily_type]['value']));
        // $this->core->data;
        for ($i = $this->core->data['daily_index']; $i < count($this->core->data[$this->core->daily_type]['value']); $i++) {


            foreach ($this->core->data['count'] as $value) {

                if ($value == $i) {

                    $this->core->set_row_daily_details($i); //this set number of row
          
                    $this->set_daily_value(); //this set data of daily 
             

                    $this->detect_number_daily_detail(); //this check for make refreshing in DailyDetail Table

                }
    
            }


        }
    }


    public function exicute($type)
    {








        $this->init_items($type);
        $this->detect_number_daily();




        return $this;
    }


    public function set_daily_value()
    {



        $this->core->account_id = (gettype($this->core->data[$this->core->daily_type]['account_id']) == 'array') ?
            $this->core->data[$this->core->daily_type]['account_id'][$this->core->row_daily_details] : $this->core->data[$this->core->daily_type]['account_id'];

        $this->core->dailyDetailId_item[$this->core->daily_type] = (gettype($this->core->data[$this->core->daily_type]['value']) == 'array') ?
            $this->core->data[$this->core->daily_type]['value'][$this->core->row_daily_details] : $this->core->data[$this->core->daily_type]['value'];

    }


    public function data_daily_detail()
    {

        //this insert data into DailyDetail Table
        $this->core->dailyDetailId_item['daily_id'] = $this->core->daily_id;
        $this->core->dailyDetailId_item['account_id'] = $this->core->account_id;

        $dailyDetailId =  DailyDetail::create($this->core->dailyDetailId_item);
        $this->core->dailyDetailId = $dailyDetailId->id;
    }




    public function store_group_account()
    {


        
        $daily = new GroupAccountDailyDetail();
        $daily->dailyable()->associate($this->core->account_details);
        $daily->daily_detail_id = $this->core->dailyDetailId;
        $daily->save();


        //  if ($this->core->daily_type == 'debit') {

        //     dd($this->core->account_details);
        // }




    }


    public function detect_number_daily_detail()
    {



  

        if (array_key_exists('account_details', $this->core->data[$this->core->daily_type])) {

          
            $this->with_daily_detail();
        } else {

  
            $this->without_daily_detail();
        }
        
    }

    public function without_daily_detail()
    {

        // (count($this->core->status_daily_detail) != 1) ? $this->data_daily_detail() : $this->get_daily_detail_id();


        $this->get_daily_detail_id();

        if (count($this->core->status_daily_detail) != 1) {

            $this->data_daily_detail();
        }
    }


    public function with_daily_detail()
    {

 
        if (
            gettype($this->core->data[$this->core->daily_type]['account_details']) == 'string' ||
            gettype($this->core->data[$this->core->daily_type]['account_details']) == 'integer' ||
            gettype($this->core->data[$this->core->daily_type]['account_details']) == 'NULL'
        ) {




            $this->one_daily_detail();
        }

   
        if (
            gettype($this->core->data[$this->core->daily_type]['account_details']) == 'array'

        ) {

            $this->multible_daily_detail();
        }
    }


    public function one_daily_detail()
    {


        $this->get_daily_detail_id();



        if (count($this->core->status_daily_detail) != 1) {

            $this->data_daily_detail();
        }



        $this->set_account_details();
    }


    public function multible_daily_detail()
    {




        $this->data_daily_detail();

        $this->set_account_details();
    }




    public function set_account_details()
    {




        // this check if account content account_details
        $this->daily_payment->check_payment_type(); //this check type of debit or credit daily as details

        $this->store_group_account(); //insert data into  group_daily_details 


        // dd(132);
    }

    public function get_daily_detail_id()
    {




        //this check if daily is founded from before
        $this->core->status_daily_detail = collect(
            tap(DailyDetail::where('daily_id', $this->core->daily_id)
                ->where('account_id', $this->core->account_id))
                ->increment($this->core->daily_type, json_decode($this->core->dailyDetailId_item[$this->core->daily_type]))
                ->get()
        )
            ->toArray();
    }
}
