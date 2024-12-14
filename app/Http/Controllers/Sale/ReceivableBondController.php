<?php

namespace App\Http\Controllers\Sale;

use App\Repository\Note\ReceivableBondRepository;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Services\CoreService;
use App\Services\DailyStockService;
use App\Services\PaymentService;
use App\Traits\Unit\UnitsTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReceivableBondController extends Controller
{
    use InvoiceTrait,
        UnitsTrait,
        GeneralTrait;


    public function __construct(
        Request $request,
        public PaymentService $payment,
        protected CoreService $core,

    ) {

        $this->core->setData($request->all());
    }


    public function index(Request $request)
    {

        [$products, $units] = ($request->id) ? $this->get_one($request) : $this->get_all($request);

        return response()->json([
            'products' => $products,
            'units' => $units,
            'customers' => $this->customers(),
            'treasuries' => $this->treasuries(),

        ]);
    }


    public function receivable_bond(Request $request)
    {





        $data = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Sale::class => function ($query) {

                    $query->with([
                        'customer',
                        'customer.group',
                        'customer.group.group_account'
                    ]);

                    $query->select('*');
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Sale')
            ->where('paymentable_id', $request->id)

            ->paginate(5);






        return response()->json([
            'list_data' => $data
        ]);
    }

    public function store_ReceivableBond(
        DailyStockService $dailyService,
        ReceivableBondRepository $note
    ) {


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $dailyService->daily()->exicute('debit')->exicute('credit');

            $note->finish();
            // dd(ReceivableNote::all());

            $this->payment->update();

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "daily created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }




    public function receivable_bond_daily(Request $request)
    {

        // dd($request->id);
        $receivable_notes  = DB::table('receivable_notes')
            ->where('receivable_notes.id', $request->id)
            ->join('dailies', 'dailies.id', '=', 'receivable_notes.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                'receivable_notes.id as receivable_note_id',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',
            )
            ->get();

        // dd($sales);
        return response()->json(['daily_details' => $receivable_notes]);
    }
    public function get_receivable_bond(Request $request)
    {



   

        // if ($request->id) {
            $data = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Sale::class => function ($query) {

                        $query->join('customers', 'customers.id', '=', 'sales.customer_id');
                        $query->join('receivable_notes', 'receivable_notes.sale_id', '=', 'sales.id');
                        $query->select(
                            'sales.*',
                            'sales.id as sale_id',
                            'customers.name as customer_name',
                            'customers.id as customer_id',
                            'receivable_notes.id as receivable_id'
                        );
                    },
                ]);
            }])
                ->where('paymentable_type', 'App\\Models\\Sale')
                ->where('paymentable_id', $request->id)
                ->paginate();
        // }


        // if ($request->customer) {
        //     $data = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
        //         $morphTo->constrain([
        //             Sale::class => function ($query) {

        //                 $query->join('customers', 'customers.id', '=', 'sales.customer_id');
        //                 $query->where('customers.id', 1);
        //                 $query->join('receivable_notes', 'receivable_notes.sale_id', '=', 'sales.id');
        //                 $query->select(
        //                     'sales.*',
        //                     'sales.id as sale_id',
        //                     'customers.name as customer_name',
        //                     'customers.id as customer_id',
        //                     'receivable_notes.id as receivable_id'
        //                 );
        //             },
        //         ]);
        //     }])
        //         ->where('paymentable_type', 'App\\Models\\Sale')
        //         ->paginate(5);
        // }




        return response()->json([
            'list_data' => $data
        ]);
    }
    public function receivableBondlist()
    {

        $customers = Customer::all();
    

        $receivable = DB::table('receivable_notes')
            ->join('sales', 'sales.id', '=', 'receivable_notes.sale_id')
            ->join('dailies', 'dailies.id', '=', 'receivable_notes.daily_id')
            ->select(

                'sales.id as sale_id',
                'receivable_notes.*',
                'dailies.total',
            )
            ->paginate(10);

        return response()->json([
            'receivable' => $receivable,
            'customers' => $customers
        ]);
    }


    // public function show(Request $request)
    // {



    //     $sales = GroupAccountDailyDetail::with(['Dailyable' => function (MorphTo $morphTo) {
    //         $morphTo->constrain([
    //             Customer::class => function ($query) {
    //                 $query->select('*');
    //             },
    //         ]);
    //     }])
    //         ->where('dailyable_type', 'App\\Models\\Customer')
    //         ->where('dailyable_id', $request->id)
    //         ->join('daily_details', 'daily_details.id', '=', 'group_account_daily_details.daily_details_id')
    //         ->paginate(5);

    //         // dd($sales);
    //     return response()->json(['sales' => $sales]);
    // }

}
