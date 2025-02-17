<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Treasury;
use Illuminate\Support\Facades\DB;
use App\Services\GroupService;
class TreasuryController extends Controller
{

    use GroupService;
    public $groups;
    public $type;
    public function init($type)
    {


        $this->type = $type;
    }
    public function index()
    {

        $treasuries = Treasury::all();
        return response()->json(['treasuries' => $treasuries]);
    }
    public function store_account_setting(Request $request)
    {

        // dd($request->all());
        foreach ($request['count'] as $value) {
            $group_accounts = Treasury::find($request->treasury[$value]);
            $group_accounts->update(['group_id' => $request->group[$value]]);

        }

        return response()->json(['message' => 'sucess']);
    }
    public function store(Request $request)
    {



        // dd($request->all());

        foreach ($request->post('count') as $value) {


            $treasury = new Treasury();
            $treasury->name =  $request['name'][$value];
            $treasury->save();
        }

        return response()->json(['message' => 'success']);
    }


    public function show()
    {
        // $treasuries = DB::table('treasuries')
        //     ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
        //     ->select('treasuries.*', 'accounts.text', 'accounts.id as account_id')
        //     ->paginate(10);


        // $treasuries =  DB::table('treasuries')
        // ->join('groups', 'groups.id', '=', 'treasuries.group_id')
        // ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
        // ->where('group_types.code', 'treasury')
        // ->select(
        //     'treasuries.*',
        //     'groups.name as group_name'
        // )
        // ->paginate(10);

        // $groups =  DB::table('groups')
        //     ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
        //     ->where('group_types.code', 'treasury')
        //     ->select(
        //         'groups.*'
        //     )
        //     ->get();

        $treasuries =  DB::table('treasuries')
            ->select()
            ->paginate();

        return response()->json([
            'treasuries' => $treasuries,
            // 'groups' => $groups
        ]);
    }


    public function get_mark_treasury()
    {

        $this->init('treasury');
        $this->groups();
        $groups =  DB::table('treasuries')
            ->join('groups', 'groups.id', '=', 'treasuries.group_id')
            ->select(
                'treasuries.id as treasury_id',
                'treasuries.name as treasury_name',
                'groups.*'
            )
            ->paginate();
        return response()->json([
            'group_lists' => $groups,
            'groups' => $this->groups,
            'treasuries' => Treasury::all(),
        ]);
    }
}
