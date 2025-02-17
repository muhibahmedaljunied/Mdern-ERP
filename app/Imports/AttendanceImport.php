<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\AttendanceDetail;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class AttendanceImport implements ToModel, WithHeadingRow
{




    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {



        $attendance = Attendance::create([

            "staff_id" => $row['staff_id'],
            "attendance_date" => $row['attendance_date'],
            "attendance_status" => $row['attendance_status'],
            "attendance_finall" => $row['attendance_finall'],
        ]);
        AttendanceDetail::create([

            "attendance_id" => $attendance->id ?? NULL,
            "period_id" => $row['period_id'],
            "check_in" => $row['check_in'],
            "check_out" => $row['check_out'],
            "duration" => $row['duration'],
            "delay" => $row['delay'],
            "leave_out" => $row['leave_out'],
            "extra" => $row['extra'],
            "extra_after" => $row['extra_after'],
        ]);

        return $attendance;
    }
}
