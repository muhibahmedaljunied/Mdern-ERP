<?php

namespace App\Http\Controllers\Account;


use App\Models\Bank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GroupService;

class BankController extends Controller
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



        $banks = Bank::all();
        return response()->json(['banks' => $banks]);
    }

    public function store(Request $request)
    {


        // $validator = Validator::make($request->all(), [
        //     'Bank_type' => 'required',
        //     'qty' => 'required',

        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        // dd($request->all());
        foreach ($request->post('count') as $value) {

            $bank = new Bank();
            $bank->name =  $request['name'][$value];

            $bank->save();
        }

        return response()->json(['message' => 'success']);
    }

    public function store_account_setting(Request $request)
    {


        foreach ($request['count'] as $value) {
            $group_accounts = Bank::find($request->bank[$value]);
            $group_accounts->update(['group_id' => $request->group[$value]]);
        }
        return response()->json(['message' => 'sucess']);
    }


    public function show()
    {
        // $banks = DB::table('banks')
        //     ->join('accounts', 'accounts.id', '=', 'banks.account_id')
        //     ->select('banks.*', 'accounts.text', 'accounts.id as account_id')
        //     ->paginate(10);

        // $banks =  DB::table('banks')
        //     ->join('groups', 'groups.id', '=', 'banks.group_id')
        //     ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
        //     ->where('group_types.code', 'bank')
        //     ->select(
        //         'banks.*',
        //         'groups.name as group_name'
        //     )
        //     ->paginate(10);

        // $groups =  DB::table('groups')
        //     ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
        //     ->where('group_types.code', 'bank')
        //     ->select(
        //         'groups.*'
        //     )
        //     ->get();

        $banks =  DB::table('banks')
            ->select()
            ->paginate();


        // dd($groups);
        return response()->json([
            'banks' => $banks,
            // 'groups' => $groups
        ]);
    }


    public function get_mark_bank()
    {

        $this->init('bank');
        $this->groups();
        $groups =  DB::table('banks')
            ->join('groups', 'groups.id', '=', 'banks.group_id')
            ->select(
                'banks.id as bank_id',
                'banks.name as bank_name',
                'groups.*'
            )
            ->paginate();
        return response()->json([
            'group_lists' => $groups,
            'groups' => $this->groups,
            'banks' => Bank::all(),
        ]);
    }

}
