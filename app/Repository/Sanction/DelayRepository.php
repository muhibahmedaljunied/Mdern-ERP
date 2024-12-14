<?php

namespace App\Repository\Sanction;

use App\Traits\staff\Sanction\DelaySanctionTrait;
use App\Services\core\CoreStaffAttendanceService;
use App\Repository\HR\DelayRepository as lRepository;

class DelayRepository
{
    use DelaySanctionTrait;

    public $total_delay;
    public function __construct(
        public CoreStaffAttendanceService $attendance_core,
        protected lRepository $hr,

    ) {

        $this->attendance_core->init('delay', 'DelaySanction');
    }
    public function create()
    {

        $this->get();
        $this->options();
    }

    public function options()
    {



        // dd($this->attendance_core->data_sanction);

        $this->calc_total();
        foreach ($this->attendance_core->data_sanction as $key => $value) {

            if ($value->code == 'sat' &&  $this->attendance_core->day == 'Saturday') {


                $this->excute_option($value);
            }

            if ($value->code == 'th' &&  $this->attendance_core->day == 'Thursday') {

                $this->excute_option($value);
            }
        }
    }

    public function excute_option($value)
    {


        if ($this->attendance_core->iterat == $value->iteration) {

            $this->attendance_core->sanction_type_id = $value->delay_sanction_id;

            $this->init_data_store($value);
            $this->hr->store($value);
            $this->attendance_core->handle_sanction();
            // $this->attendance_core->payroll();
        }
    }
    public function calc_total_for_current()
    {

        $this->total_delay = 0;
        $this->attendance_core->current_attendance();
        foreach ($this->attendance_core->attendance as $key => $total) {


            $this->total_delay += $total->delay;
        }
    }


    public function calc_total_for_all()
    {

        $count = 0;
        $total_delay = 0;
        $this->attendance_core->all_attendance();
        foreach ($this->attendance_core->all_attendance as $key => $total) {


            $total_delay += $total->delay;

            if ($this->total_delay == $total_delay) {


                $count += 1;
            }
        }


        $this->attendance_core->iterat = $count;
    }



    public function init_data_store($value)
    {



        $this->hr->staff_id = $this->attendance_core->data['staff'][$this->attendance_core->value];
        $this->hr->delay_type_id = $value->delay_type_id;
        $this->hr->part_id = $value->part_id;
        $this->hr->date = $this->attendance_core->data['attendance_date'];
    }

    public function calc_total()
    {

        $this->calc_total_for_current();
        $this->calc_total_for_all();
    }
}
