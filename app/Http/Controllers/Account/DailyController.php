<?php

namespace App\Http\Controllers\Account;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DailyService;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Services\DailyStockService;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        // protected DailyService $service

        public DailyStockService $daily,

    ) {

        // $this->service = $service;
    }
    public function index()
    {


        $sum_debit = 0;
        $sum_credit = 0;

        $daily_details =  Account::join('daily_details', 'daily_details.account_id', '=', 'accounts.id')
            ->select('accounts.*', 'daily_details.*')
            ->paginate(100);

        foreach ($daily_details as $value) {

            $sum_debit += $value->debit;
            $sum_credit += $value->credit;
        }

        // dd($daily_details->sum_credit);
        return response()->json([
            'daily_details' => $daily_details,
            'sum_debit' => $sum_debit,
            'sum_credit' => $sum_credit
        ]);
    }

    public function account_report(Request $request)
    {

        $sum_debit = 0;
        $sum_credit = 0;
        $account_details =  Account::join('daily_details', 'daily_details.account_id', '=', 'accounts.id')
            ->where('daily_details.account_id', $request->id)
            ->select('accounts.*', 'daily_details.*')
            ->paginate(100);

        foreach ($account_details as $value) {

            $sum_debit += $value->debit;
            $sum_credit += $value->credit;
        }


        // dd($account_details->sum_credit);
        return response()->json([
            'account_details' => $account_details,
            'sum_debit' => $sum_debit,
            'sum_credit' => $sum_credit
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        // $this->service->data_store = $request;

        // $this->service->handle();



        return response()->json($request->all());
    }

    public function store_daily_openning_balance(Request $request)
    {


        // dd($request->all());         

        $this->daily->daily()->exicute('debit')->exicute('credit');
    }

    public function daily_close(Request $request)
    {


        $expence =  Account::Join(
            DB::raw('(SELECT account_id,SUM(debit) AS sum_debit,SUM(credit) AS sum_credit  FROM daily_details 
            GROUP BY account_id) AS n'),
            'n.account_id',
            '=',
            'accounts.id'
        )
            ->whereIn('accounts.account_type', [6, 7])
            ->where([
                'status_account' =>
                false,

            ])
            ->select('accounts.id as account_id', 'accounts.account_type',DB::raw('sum_debit - sum_credit as fff'))
            ->get();

            dd($expence);

        $array_data = [];
        foreach ($expence as $key => $value) {


            // dd($value['account_type']);

            if ($value['account_type'] == 6) {

                $array_data['debit']['account_id'][$key] = $value['account_id'];
                $array_data['debit']['value'][$key] = $value['debit'];
                // $debit['account_details'] = ;

            }

            if ($value['account_type'] == 7) {

                $array_data['credit']['account_id'][$key] = $value['account_id'];
                $array_data['credit']['value'][$key] = $value['debit'];
                //     // $debit['account_details'] = ;

            }
        }


        dd($array_data);



        // ------------------------------------------------------------------------------------------
        // $credit['account_id'] = ;
        // $credit['value'] = ;
        // $credit['account_details'] = ;

        // ------------------------------
        // $debit['account_id'] =  {
        //     account_id: this.storem_account,
        //     value: this.total,
        //     account_details: this.storem,

        //   },
        //   credit: {

        //     account_id: $(`#Purchase_account_tree_id`).val(),
        //     value: this.sub_total,
        //     account_details: $(`#select_account_${this.type}_group`).val(),

        //   },


        // ------------------------------

        dd($expence);



        $this->daily->daily()->exicute('debit')->exicute('credit');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $sum_debit = 0;
        $sum_credit = 0;

        $daily_details =  Account::join('daily_details', 'daily_details.account_id', '=', 'accounts.id')
            ->where('daily_id', $request->id)
            ->select('accounts.*', 'daily_details.*')
            ->paginate(100);

        foreach ($daily_details as $value) {

            $sum_debit += $value->debit;
            $sum_credit += $value->credit;
        }

        // dd($daily_details->sum_credit);
        return response()->json([
            'daily_details' => $daily_details,
            'sum_debit' => $sum_debit,
            'sum_credit' => $sum_credit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function edit(Daily $daily)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Daily $daily)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function destroy(Daily $daily)
    {
        //
    }
}
