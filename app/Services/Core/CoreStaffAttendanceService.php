<?php

namespace App\Services\core;

use App\Services\CoreService;
use App\Traits\Staff\Sanction\SanctionTrait;
use App\Traits\staff\AttendanceTrait;

class CoreStaffAttendanceService extends CoreService
{
    use SanctionTrait, AttendanceTrait;

    public $attendance_details_id = 0;
    public $sort_period;
    public $sanction_type_id;
    public $data_sanction;
    public $temporale_f;
    public $updating_data;
    public $attendance_id;
    public $attendance;
    public $all_attendance;
    public $sanction;
    public $iterat;
    public $type;
    public $table;
    public $day;


    public function init($type, $table)
    {

        $this->setDay();
        $this->setType($type);
        $this->setTable($table);
    }
    public function handle_sanction()
    {



        // if ($this->type != 'extra') {
        //     dd($this->type);
        // }
  

        $this->get_sanction();

        $this->staff_sanction();
    }



    public function setDay()
    {

        $this->day = date('l', strtotime($this->data['attendance_date']));
    }

    public function setType($type)
    {

        $this->type = $type;
    }


    public function setTable($table)
    {

        $this->table = $table;
    }
}
