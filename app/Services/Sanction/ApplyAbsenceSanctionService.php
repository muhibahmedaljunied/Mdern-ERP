<?php

namespace App\Services;

use App\Services\core\CoreStaffAttendanceService;
use App\Services\Staff\AbsenceService;
use Illuminate\Http\Request;

class ApplyAbsenceSanctionService
{
   
    public function filter_date($request)
    {

        $request->staff_id = collect($request->staff_id)->toArray();


        $this->core->array_filter = [];
        $year = intval(date("2024"));
        $month = intval(date("11"));
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);


        for ($i = 1; $i < $days; $i++) {

            if ($this->get_day_name("$year-$month-$i") == $request->absence_type_code) {

                $this->core->array_filter[$i] =  $year . '-' . $month . '-' . $i;
            }
        }
    }


    public function staff_attendance($request)
    {



        $this->core->attendances = DB::table('attendances')
            ->select(
                'staff.name',
                'staff.id as staff_id',
                DB::raw('count(attendances.id) as attendance'),

            )
            ->groupBy(
                'staff.name',
                'staff.id',

            )


            ->whereIn('attendance_date', $this->core->array_filter)
            ->join('staff', 'staff.id', '=', 'attendances.staff_id');

        if (count($request->staff_id) > 0) {

            $this->core->attendances = $this->core->attendances->where('staff.id', $request->staff_id[0]);
        }

        $this->core->attendances = $this->core->attendances->paginate();



        // dd($this->core->attendances);
    }




    public function final_sanction($request)
    {

        // dd($request->absence_type_id);
        foreach ($this->core->attendances as $value) {





            $absence =  collect(AbsenceSanction::join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
                ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                ->where('absence_sanctions.absence_type_id', $request->absence_type_id)
                ->where('absence_sanctions.iteration', $value->attendance)
                ->select(
                    'absence_sanctions.*',
                    'sanction_discounts.name',
                    'absence_types.name as absence_name'
                )
                ->get())->toArray();



            if (count($absence) > 0) {


                foreach ($absence as $key => $value2) {

                    $staff_sanction =  collect(StaffSanction::where('sanctionable_type', 'App\Models\AbsenceSanction')
                        ->where('sanctionable_id', $value2['id'])
                        ->where('staff_id', $value->staff_id)
                        ->select(
                            '*'
                        )
                        ->get())->toArray();



                    if (count($staff_sanction) > 0) {   //if found staff_sanction do not return sanction

                        $value->staff_sanction[$key] = $staff_sanction;
                    } else {

                        $value->absence[$key] = $value2;
                    }
                }
            }


         
        }

        // dd($this->core->attendances);
    }



}
