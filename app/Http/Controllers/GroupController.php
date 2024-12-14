<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Group;
use App\Models\GroupAccount;
use App\Models\GroupDailyDetail;
use App\Services\GroupService;
use App\Services\HrGroupService;
use App\Models\GroupType;
use App\Models\Supplier;
use App\Models\Treasury;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


class GroupController extends Controller
{

    public $result;
    public $type;
    public $groups;
    public $group_lists;
    public $group_types;

    use GroupService, HrGroupService;


    public function init($type)
    {


        $this->type = $type;
    }
    public function store_account_setting(Request $request)
    {



  

        foreach ($request['count'] as $value) {


            $groups = new GroupAccount();
            $groups->account_id = $request->account[$value];
            $groups->group_id = $request->group[$value];
            $groups->save();



            // dd($request['group'][$value]);
            // Group::where([

            //     'id' => $request['group'][$value],
            //     'group_type_id' => $request['type_group'][$value]

            // ])->update();


            // $group_accounts = Group::where(
            //     [
            //         'id' => $request['group'][$value],
            //         'group_type_id' => $request['type_group'][$value]
            //     ]
            // );
            // $group_accounts->update(['account_id' => $request['account'][$value]]);
        }
        return response()->json(['message' => 'sucess']);
    }


    public function get_groups()
    {


        $groups =  DB::table('groups')
            ->join('group_types', 'groups.group_type_id', '=', 'group_types.id')
            ->select(
                'groups.*',
                'group_types.name as type_name',
            )

            ->get();
        $group_types =  DB::table('group_types')->select(
            'group_types.name as type_name',
            'group_types.id as group_type_id'
        )
            ->get();
        return response()->json(['groups' => $groups, 'group_types' => $group_types]);
    }

    public function get_group(Request $request)
    {
        
        $this->init($request->code);
        $this->groups();
        return response()->json(['groups' => $this->groups]);
    }


    public function get_group_mark()
    {


        $this->group_lists();
        $this->group_types();
        return response()->json([
            'group_lists' => $this->group_lists,
            'group_types' => $this->group_types

        ]);
    }

    public function get_group_mark_hr()
    {

        $this->init('hr');
        $this->group_lists();
        $this->group_types();
        return response()->json([
            'group_lists' => $this->group_lists,
            'group_types' => $this->group_types

        ]);
    }

    public function get_group_mark_treasury()
    {

        // stm32f103c8t69902q

        $this->init('treasury');
        $this->group_lists();
        $this->groups();
        return response()->json([
            'group_lists' => $this->group_lists,
            'groups' => $this->groups,
            'treasuries' => Treasury::all(),
        ]);
    }

    public function get_group_mark_customer()
    {


        $this->init('customer');
        $this->group_lists();
        $this->groups();
        return response()->json([
            'group_lists' => $this->group_lists,
            'groups' => $this->groups,
            'customers' => Customer::all(),
        ]);
    }
    public function get_group_mark_supplier()
    {



        $this->init('supplier');
        $this->group_lists();
        $this->groups();
        return response()->json([
            'group_lists' => $this->group_lists,
            'groups' => $this->groups,
            'suppliers' => Supplier::all(),
        ]);
    }

    public function get_group_mark_bank()
    {

        $this->init('bank');
        $this->group_lists();
        $this->groups();
        return response()->json([
            'group_lists' => $this->group_lists,
            'groups' => $this->groups,
            'banks' => Bank::all(),
        ]);
    }





    public function get_group_types()
    {



        $group_types =  DB::table('group_types')->select('group_types.*')->get();
        return response()->json(['group_types' => $group_types]);
    }



    public function get_group_hr(Request $request, $id)
    {




        $this->check_group_hr($request->code);

        return response()->json([
            'groups' => $this->group($id),
            'result' => $this->result,

        ]);
    }

    public function check_group_hr($code)
    {




        if ($code == 'allowance') {


            return $this->get_allowance();
        }

        if ($code == 'extra') {


            return $this->get_extra();
        }

        if ($code == 'discount') {


            return $this->get_discount();
        }


        if ($code == 'delay') {


            return $this->get_delay();
        }



        if ($code == 'absence') {


            return $this->get_absence();
        }



        if ($code == 'leave') {


            return $this->get_leave();
        }
    }

    public function store_group(Request $request)
    {






        foreach ($request['count'] as $value) {

            $groups = new Group();
            $groups->name = $request->name[$value];
            $groups->code = $request->code[$value];
            $groups->group_type_id = $request->type[$value];
            $groups->save();
        }

        return response()->json(['groups' => $groups]);
    }

    public function store_group_type(Request $request)
    {





        foreach ($request['count'] as $value) {

            $groups = new GroupType();
            $groups->name = $request->name[$value];
            $groups->code = $request->code[$value];
            $groups->status = $request->status[$value];

            $groups->save();
        }

        return response()->json(['groups' => $groups]);
    }
}
