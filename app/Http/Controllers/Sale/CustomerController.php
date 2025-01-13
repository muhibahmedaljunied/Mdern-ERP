<?php

namespace App\Http\Controllers\Sale;

use App\Exports\CustomerExport;
use App\Models\Customer;
use App\Models\Sale;
use App\Http\Controllers\Controller;
use App\Imports\CustomerImport;
use App\Models\Group;
use App\Models\GroupAccountDailyDetail;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{

    public function index()
    {

        $customers = DB::table('customers')
            // ->join('groups', 'groups.id', '=', 'customers.group_id')
            // ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            // ->where('group_types.code', 'customer')
            ->select(
                'customers.*',
                // 'customer_accounts.account_id',
                // 'groups.name as group_name'
            )
            ->paginate(10);



        return response()->json(['customers' => $customers]);
    }


    public function show(Request $request)
    {


        $results = [];

        $results['sales'] = collect(GroupAccountDailyDetail::with(['Dailyable'])
            ->where('dailyable_type', 'App\\Models\\Customer')
            ->where('dailyable_id', $request->id)
            ->join('daily_details', 'daily_details.id', '=', 'group_account_daily_details.daily_details_id')
            ->join('dailies', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('sales', 'dailies.id', '=', 'sales.daily_id')
            ->get())->toArray();

        $results['receivable_notes'] = collect(GroupAccountDailyDetail::with(['Dailyable'])
            ->where('dailyable_type', 'App\\Models\\Customer')
            ->where('dailyable_id', $request->id)
            ->join('daily_details', 'daily_details.id', '=', 'group_account_daily_details.daily_details_id')
            ->join('dailies', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('receivable_notes', 'receivable_notes.daily_id', '=', 'dailies.id')

            ->get())->toArray();


        $total_debit = 0;
        $total_credit = 0;

        foreach ($results as $result) {


            foreach ($result as $value) {

                $total_debit += $value['debit'];
                $total_credit += $value['credit'];
            }
        }


        $results['total_debit'] = $total_debit;
        $results['total_credit'] = $total_credit;
        $results['total'] = $total_credit - $total_debit;





        return response()->json(['sales' => $results]);
    }


    public function import(Request $request)
    {

        Excel::import(new CustomerImport, storage_path('customer.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported'
        ]);
    }


    public function export()
    {

        Excel::download(new CustomerExport, 'supplier.xlsx');


        return response()->json([
            'status' =>
            'The file has been excel/csv exporteded'
        ]);
    }


    public function get_customer_account_setting()
    {



        $groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'customer')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();

        $group_accounts =  DB::table('groups')
            ->join('accounts', 'accounts.id', '=', 'groups.account_id')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'customer')
            ->select(
                'groups.id as group_id',
                'groups.name as group_name',
                'accounts.id as account_id',
                'accounts.text as account_name'
            )
            ->get();


        return response()->json(['groups' => $groups, 'group_accounts' => $group_accounts]);
    }

    public function store_customer_account_setting(Request $request)
    {


        $group_accounts = Group::find($request['group_id']);
        $group_accounts->update(['account_id' => $request['account_id']]);

        return response()->json(['message' => 'sucess']);
    }

    public function search(Request $request)
    {
        $customers = Customer::where('customers.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->select('customers.*')
            ->paginate(10);
        return response()->json($customers);
    }


    public function create() {}

    // public function show(Request $request)
    // {
    //     // return response()->json(['sales' => $request->all()]);


    //     $sales =  Sale::where('customer_id', $request->id)->with([

    //         'receivable_notes' => function ($query) {
    //             $query->select('*');
    //         },
    //         'payments' => function ($query) {
    //             $query->select('*');
    //         },
    //         'sale_returns' => function ($query) {
    //             $query->select('*');
    //         }

    //     ])->paginate(10);






    //     return response()->json(['sales' => $sales]);
    // }



    // public function get_customer_account(Request $request){



    //     $customers = DB::table('customers')
    //         ->join('groups', 'groups.id', '=', 'customers.group_id')
    //         ->where('groups.account_id', $request->id)
    //         ->select('customers.id', 'customers.name')
    //         ->get();

    //     return response()->json(['customers' => $customers]);

    // }
    public function store(Request $request)
    {

        // dd($request->all());


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction



            //   // -------------------------------------------------------------------------
            //   $customer_service->get_parent();
            //   // ---------------------------------------------------------------------------
            //   $customer_service->get_child();
            //   // -------------------------------------------------------------------------
            //   $customer_service->add_account();
            //   // -------------------------------------------------------------------------
            //   $customer_service->add_Customer();






            // -------------------------------------------------------------------------
            // $parent =  DB::table('accounts')
            //     ->where('accounts.id', $request->post('account'))
            //     ->select(
            //         'accounts.id',
            //         'accounts.text',
            //         'accounts.rank',
            //     )
            //     ->first();


            // // -------------------------------------------------------------------------

            // $childs = Account::where('parent_id', $parent->id)->select('accounts.*')->max('id');
            // $id = ($childs == null) ? $request->post('account') * 10 + 1 : $childs + 1;

            // // ----------------------------------------------------------------------------------
            // $account = new Account();
            // $account->id = $id;
            // $account->text = 'العميل' . ' ' . $request->post('name');
            // $account->parent_id = $parent->id;
            // $account->rank = $parent->rank + 1;
            // $account->status_account = false;
            // $account->save();

            // -------------------------------------------------------------------------

            foreach ($request->post('count') as $value) {
                
                $customer = new Customer();
                $customer->name = $request->post('name')[$value];
                $customer->phone = $request->post('phone')[$value];
                $customer->email = $request->post('email')[$value];
                $customer->address = $request->post('address')[$value];
                // $customer->account_id = $id;
                // $customer->group_id = $request->post('group')[$value];
                // $customer->status = $request->post('status')[$value];
                $customer->save();
            }


            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }

        return back();
    }




    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json(['customer' => $customer]);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->update($request->post());
        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        return response()->json('successfully deleted');
    }
}
