<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

trait GroupService
{


    public function group_lists()
    {



        $this->group_lists =  DB::table('group_accounts');
        $this->group_lists = $this->group_lists->join('accounts', 'accounts.id', '=', 'group_accounts.account_id')
            ->join('groups', 'group_accounts.group_id', '=', 'groups.id')
            ->join('group_types', 'groups.group_type_id', '=', 'group_types.id');



        if ($this->type) {


            if ($this->type == 'hr') {


                $this->group_lists = $this->group_lists->where(function ($query) {

                    $query->where('group_types.code', 'extra');
                    $query->orwhere('group_types.code', 'allowance');
                    $query->orwhere('group_types.code', 'discount');
                    $query->orwhere('group_types.code', 'advance');
                    $query->orwhere('group_types.code', 'absence');
                    $query->orwhere('group_types.code', 'delay');
                    $query->orwhere('group_types.code', 'leave');
                });
            } else {

                $this->group_lists = $this->group_lists->where('group_types.code', $this->type);
            }
        }


        $this->group_lists =  $this->group_lists->select(
            'groups.*',
            'group_types.name as type_name',
            'accounts.*',


        )

            ->get();
    }

    public function group($id)
    {


        return  collect(
            DB::table('groups')
                ->join('group_types', 'groups.group_type_id', '=', 'group_types.id')
                ->where('group_types.id', $id)
                ->select(
                    'groups.*',
                )
                ->get()
        )
            ->toArray();
    }

    public function groups()
    {


        $this->groups =  DB::table('group_types')
            ->join('groups', 'group_types.id', '=', 'groups.group_type_id')
            ->select(
                'group_types.name as type_name',
                'group_types.id as group_type_id',
                'group_types.code as group_type_code',
                'groups.code as code_group',
                'groups.name as group_name',
                   'groups.id as group_id'

            )
            ->where(function ($query) {

                $query->where('group_types.code', $this->type);
            })

            ->get();
    }

    public function  group_types()
    {


        if ($this->type) {

            $this->group_types =  DB::table('group_types')

                ->where(function ($query) {

                    $query->where('group_types.code', 'extra');
                    $query->orwhere('group_types.code', 'allowance');
                    $query->orwhere('group_types.code', 'discount');
                    $query->orwhere('group_types.code', 'advance');
                    $query->orwhere('group_types.code', 'absence');
                    $query->orwhere('group_types.code', 'delay');
                    $query->orwhere('group_types.code', 'leave');
                })


                ->select(
                    'group_types.name as type_name',
                    'group_types.id as group_type_id',
                    'group_types.code as group_type_code'

                )

                ->get();
        } else {


            $this->group_types =  DB::table('group_types')

                ->select(
                    'group_types.name as type_name',
                    'group_types.id as group_type_id',
                    'group_types.code as group_type_code'

                )

                ->get();
        }







        // dd($this->group_types);
    }
}
