<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class AttendanceExport implements WithMapping, WithHeadings, FromCollection
{

    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {

        return Attendance::with('attendance_details')->get();
    }

    public function map($opening): array
    {





        return [
            // ---------------attendance-----------------------
            $opening->staff_id,
            $opening->attendance_date,
            $opening->attendance_status,
            $opening->attendance_finall,

            // --------------------attendance_details------------------
            $opening->attendance_details[0]->attendance_id,
            $opening->attendance_details[0]->period_id,
            $opening->attendance_details[0]->check_in,
            $opening->attendance_details[0]->check_out,
            $opening->attendance_details[0]->duration,
            $opening->attendance_details[0]->delay,
            $opening->attendance_details[0]->leave_out,
            $opening->attendance_details[0]->extra,
            $opening->attendance_details[0]->extra_after,





        ];
    }






    public function headings(): array
    {
        return [

            // ---------------attendance-----------------------
            "staff_id",
            "attendance_date",
            "attendance_status",
            "attendance_finall",
            // --------------------attendance_details------------------
            'attendance_id',
            'period_id',
            'check_in',
            'check_out',
            'duration',
            'delay',
            'leave_out',
            'extra',
            'extra_after',






        ];
    }
}
