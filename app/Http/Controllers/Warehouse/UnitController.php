<?php

namespace App\Http\Controllers\Warehouse;


use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return response()->json([
            'units' => Unit::all(),
            'status' => Status::all(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //    dd($request['count']);
        foreach ($request['count'] as $value) {

            $unit = new Unit();
            $unit->name = $request['name'][$value];
            $unit->save();
        }

        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $units = Unit::where('product_units.product_id', $request->id)
        //     ->join('product_units', 'units.id', '=', 'product_units.unit_id')
        //     ->join('products', 'product_units.product_id', '=', 'products.id')
        //     ->select('units.*', 'product_units.*')

        //     ->get();



        $products = DB::table('products')
            ->join('store_products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->select(
                'products.*',
                'store_products.id as store_product_id',
                'store_products.desc',
<<<<<<< HEAD
                'statuses.name',
                'statuses.id as status_id'
=======
                'statuses.name'
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5
            )
            ->get();

        foreach ($products as $value) {

            $value->kk = collect(DB::table('family_attribute_options')
                ->where('family_attribute_options.store_product_id', $value->store_product_id)
                ->join('attribute_options', 'attribute_options.id', '=', 'family_attribute_options.attribute_option_id')
                ->join('attributes', 'attributes.id', '=', 'attribute_options.attribute_id')
                ->get())->toArray();
        }

        foreach ($products as $value) {


            $value->unit = Unit::where('product_units.product_id', $value->id)
                ->join('product_units', 'units.id', '=', 'product_units.unit_id')
                // ->join('products', 'product_units.product_id', '=', 'products.id')
                ->join('product_prices', 'product_prices.product_unit_id', '=', 'product_units.id')
                ->select(
                    'units.*',
                    'product_units.*',
                    'product_prices.*'
                )

                ->get();
        }


        return response()->json([
            // 'units' => $units,

            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
