<?php

namespace App\Services;

use App\Services\core\CoreStaffAttendanceService;
use App\Services\Staff\AbsenceService;
use Illuminate\Http\Request;

class ApplyExtraSanctionService
{
   


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
            );

        if ($request->extra_type_code == 'before_work') {

            $this->core->attendances = $this->core->attendances->Join(
                DB::raw('(SELECT attendance_id,SUM(extra) AS revenue FROM attendance_details 
                    GROUP BY attendance_id) AS n'),
                'n.attendance_id',
                '=',
                'attendances.id'
            );
        }

        if ($request->extra_type_code == 'after_work') {

            $this->core->attendances = $this->core->attendances->Join(
                DB::raw('(SELECT attendance_id,SUM(extra_after) AS revenue FROM attendance_details 
                    GROUP BY attendance_id) AS n'),
                'n.attendance_id',
                '=',
                'attendances.id'
            );
        }



        $this->core->attendances = $this->core->attendances->where('revenue', $request->extra_part_duration)
            // ->whereIn('attendance_date', $this->core->array_filter)
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

        // dd($request->extra_type_id);

        foreach ($this->core->attendances as $value) {





            $extra =  collect(ExtraSanction::join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
                ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
                ->where('extra_sanctions.part_id', $request->extra_part_id)
                ->where('extra_sanctions.extra_type_id', $request->extra_type_id)
                ->where('extra_sanctions.iteration', $value->attendance)
                ->select(
                    'extra_sanctions.*',
                    'sanction_discounts.name',
                    'extra_types.name as extra_name'
                )
                ->get())->toArray();



            if (count($extra) > 0) {

              
                foreach ($extra as $key => $value2) {

                    $staff_sanction =  collect(StaffSanction::where('sanctionable_type', 'App\Models\ExtraSanction')
                        ->where('sanctionable_id', $value2['id'])
                        ->where('staff_id', $value->staff_id)
                        ->select(
                            '*'
                        )
                        ->get())->toArray();



                    if (count($staff_sanction) > 0) {   //if found staff_sanction do not return sanction

                        $value->staff_sanction[$key] = $staff_sanction;
                    } else {

                        $value->extra[$key] = $value2;
                    }
                }
            }
        }



    }


}
