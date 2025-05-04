<?php

namespace App\Http\Controllers\Warehouse;

use App\Services\FilterService;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{

    public function index()
    {


        return response()->json([
            'units' => Unit::all(),
            'status' => Status::all(),

        ]);
    }


    public function create()
    {
        //
    }


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

    public function category_filter(Request $request, FilterService $filter)
    {



        $filter->product_id =  $request->id;
        $filter->queryfilter();


        return response()->json([
            'products' => $filter->data,
        ]);
    }


    public function show(Request $request)
    {


        // dd($request->id);


        $products = DB::table('products')
            ->where('products.id', $request->id)
            ->join('store_products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->select(
                'products.*',
                'store_products.id as store_product_id',
                'store_products.desc',
                'statuses.name',
                'statuses.id as status_id'
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


            $value->unit = ProductUnit::where([
                'product_prices.store_product_id' => $value->store_product_id
            ])
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('product_prices', 'product_prices.product_unit_id', '=', 'product_units.id')
                ->select(
                    'units.*',
                    'product_units.*',
                    'product_units.id as product_unit_id',
                    'product_prices.*',
                )

                ->get();
        }



        return response()->json([
            'products' => $products
        ]);
    }


    public function edit()
    {
        //
    }


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
