<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

trait HrGroupService
{

    public function get_allowance()
    {



        $this->result =  DB::table('allowance_types')
            ->select(
                'allowance_types.*',
            )
            ->get();
    }


    public function get_extra()
    {

        return collect(DB::table('extra_types')
            ->select(
                'extra_types.*',
            )
            ->get())->toArray();
    }

    public function get_discount()
    {

        // return DB::table('extra_types')
        // ->select(
        //     'extra_types.*',
        // )
        // ->get();


    }


    public function get_delay()
    {

        return DB::table('delay_types')
            ->select(
                'delay_types.*',
            )
            ->get();
    }



    public function get_absence()
    {

        return DB::table('absence_types')
            ->select(
                'absence_types.*',
            )
            ->get();
    }

    public function get_leave()
    {

        return DB::table('leave_types')
            ->select(
                'leave_types.*',
            )
            ->get();
    }
}
