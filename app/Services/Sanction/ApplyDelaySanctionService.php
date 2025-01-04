<?php

namespace App\Services;

use App\Services\core\CoreStaffAttendanceService;
use App\Services\Staff\AbsenceService;
use Illuminate\Http\Request;

class ApplyDelaySanctionService
{
   


    
    public function filter_date($request)
    {

        $request->staff_id = collect($request->staff_id)->toArray();


        $this->core->array_filter = [];
        $year = intval(date("2024"));
        $month = intval(date("11"));
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);


        for ($i = 1; $i < $days; $i++) {

            if ($this->get_day_name("$year-$month-$i") == $request->delay_type_code) {

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
                'revenue',
            )
            ->groupBy(
                'staff.name',
                'staff.id',
                'revenue',
            )
            ->Join(
                DB::raw('(SELECT attendance_id,SUM(delay) AS revenue FROM attendance_details 
                GROUP BY attendance_id) AS n'),
                'n.attendance_id',
                '=',
                'attendances.id'
            )
            ->where('revenue', $request->delay_part_duration)
            ->whereIn('attendance_date', $this->core->array_filter)
            ->join('staff', 'staff.id', '=', 'attendances.staff_id');
       
        if (count($request->staff_id) > 0) {

            $this->core->attendances = $this->core->attendances->where('staff.id', $request->staff_id[0]);
        }
        $this->core->attendances = $this->core->attendances->orderBy('revenue')
            ->paginate();



        // dd($this->core->attendances);
    }




    public function final_sanction($request)
    {

        // dd($request->delay_type_id);

        foreach ($this->core->attendances as $value) {





            $delay =  collect(DelaySanction::join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
                ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
                ->where('delay_sanctions.part_id', $request->delay_part_id)
                ->where('delay_sanctions.delay_type_id', $request->delay_type_id)
                ->where('delay_sanctions.iteration', $value->attendance)
                ->select(
                    'delay_sanctions.*',
                    'sanction_discounts.name',
                    'delay_types.name as delay_name'
                )
                ->get())->toArray();



            if (count($delay) > 0) {


                foreach ($delay as $key => $value2) {

                    $staff_sanction =  collect(StaffSanction::where('sanctionable_type', 'App\Models\DelaySanction')
                        ->where('sanctionable_id', $value2['id'])
                        ->where('staff_id', $value->staff_id)
                        ->select(
                            '*'
                        )
                        ->get())->toArray();



                    if (count($staff_sanction) > 0) {   //if found staff_sanction do not return sanction

                        $value->staff_sanction[$key] = $staff_sanction;
                    } else {

                        $value->delay[$key] = $value2;
                    }
                }
            }


        
    }






}
