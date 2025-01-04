<?php

namespace App\Services;

class CoreStaffService extends CoreService
{

    public $attendances;
    public $array_filter = [];
    public $array_filter2 = [];
    
    public $data_sanction;
    public $id;
    public $temporale_f;
    public $status_sanction = false;
    public $specific_sanction;
    public $data_of_hr_for_update_payroll;
    // ---------------------
    public $debit = [];
    public $credit = [];
    public $paid =[];
    public $hr_account_id = [];

}
