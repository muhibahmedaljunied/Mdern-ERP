<?php

namespace App\Repository\Sanction;

use App\Services\core\CoreStaffAttendanceService;
use App\Traits\staff\Sanction\LeaveSanctionTrait;
use App\Repository\HR\LeaveRepository as lRepository;


class LeaveRepository
{
    use LeaveSanctionTrait;

    public $total_leave;
    public function __construct(
        protected CoreStaffAttendanceService $attendance_core,
        protected lRepository $hr,

    ) {

        $this->attendance_core->init('leave', 'LeaveSanction');
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

                if ($this->attendance_core->iterat == $value->iteration) {

                    $this->attendance_core->sanction_type_id = $value->leave_sanction_id;

                    $this->init_data_store($value);

                    $this->hr->store();
                    $this->attendance_core->handle_sanction();
                    // $this->attendance_core->payroll();

                }
            }
        }
    }

    public function calc_total_for_current()
    {


        $this->total_leave = 0;
        $this->attendance_core->current_attendance();
        foreach ($this->attendance_core->attendance as $key => $total) {

            $this->total_leave += $total->leave;
        }

        // dd($this->total_leave);

    }


    public function calc_total_for_all()
    {

        $count = 0;
        $total_leave = 0;
        $this->attendance_core->all_attendance();
        foreach ($this->attendance_core->all_attendance as $key => $total) {


            $total_leave += $total->leave;


            if ($this->total_leave == $total_leave) {


                $count += 1;
            }
        }

        // dd($count);
        $this->attendance_core->iterat = $count;
    }

    public function init_data_store($value)
    {


        $this->hr->staff_id = $this->attendance_core->data['staff'][$this->attendance_core->value];
        $this->hr->leave_type_id = $value->leave_type_id;
        $this->hr->part_id = $value->part_id;
        $this->hr->date = $this->attendance_core->data['attendance_date'];
    }


    public function calc_total()
    {

        $this->calc_total_for_current();
        $this->calc_total_for_all();
    }
}
