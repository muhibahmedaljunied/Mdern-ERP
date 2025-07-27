<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterService
{
    public $array_where = [];
    public $array_attribute = [];
    public $group_array_attribute = [];
    public $count = 0;
    public  $tree_id;
    public $array_data;
    public $root;
    public $link;
    public $type;
    public $request;
    public $data = [
        [
            "id" => 0,
            "text" => 0,
            "rank" => 0,
            "status" => 0,
            "parent_id" => 0,
        ]

    ];
    public function __construct(
        Request $request,

    ) {

        $this->request = $request;
        $this->tree_id =  $this->request->id;
        $this->type =  $this->request->type;
    }

    function wherefilter()
    {



        $i = 0;
        $i1 = 0;

        foreach ($this->array_data as $key => $value) {


            foreach ($value as $key2 => $value2) {




                if ($value2 == 'true') {

                    $this->array_where[$i1] = $key2;
                    // dd($this->array_where);
                }

                $i1 = $i1 + 1;
            }


            $i = $i + 1;
        }
        return $this;
    }

    public function foreach_root($link)
    {


        foreach ($link as $value) {

            $this->filter($value);
        }
    }

    function filter($value)
    {



        if ($value['children'] == null) {

            ($this->type == 'store') ? $this->product_detail_by_store($value) : $this->product_detail($value);
        } else {
            $this->foreach_root($value['children']);
        }
    }

    function queryfilter()
    {





        ($this->type == 'store') ? $this->store() : $this->product();

        // dd($this->data);
        return $this->data;
    }



    public function store()
    {

        $store = Store::where(function ($query) {

            return $query->where('parent_id', '=', $this->tree_id)
                ->orWhere('id', '=', $this->tree_id)->where('status', '=', 'false');
        })
            ->with('children')
            ->get();

        $this->root = collect($store)->toArray();
        $this->foreach_root($this->root);
    }
    public function product()
    {

        $product = Product::where(function ($query) {

            return $query->where('parent_id', '=', $this->tree_id)
                ->orWhere('id', '=', $this->tree_id)->where('status', '=', 'false');
        })
            ->with('children')
            ->get();

        $this->root = collect($product)->toArray();
        $this->foreach_root($this->root);
    }

    // function get_details($value)
    // {


    //     if ($value['status'] == 'false') {


    //         $product = StoreProduct::where('store_products.quantity', '!=', 0)
    //             ->where('store_products.product_id', '=', $value['id'])
    //             ->join('stores', 'store_products.store_id', '=', 'stores.id')
    //             ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
    //             ->join('products', 'store_products.product_id', '=', 'products.id')
    //             ->select(
    //                 'products.*',
    //                 'products.text as product',
    //                 'statuses.name as status',
    //                 'store_products.quantity as availabe_qty',
    //                 'store_products.*',
    //                 'store_products.cost as price',
    //                 'store_products.id as store_product_id',
    //                 'stores.text as store',

    //             )
    //             ->get();

    //         // dd($product);

    //         foreach ($product as  $value) {

    //             $this->data[$this->count] = $value;
    //             #
    //             $this->count = $this->count + 1;
    //         }
    //     }
    // }



    public function product_detail($value = null)
    {


        if (
            $this->request->segment(2) == 'newpurchase' ||
            $this->request->segment(2) == 'newsupply' ||
            $this->request->segment(1) == 'show_product' ||
            $this->request->segment(1) == 'opening'
        ) {

            $this->product_detail_by_product($value);
        } elseif ($this->request->segment(1) == 'get_product_price') {

            $this->product_detail_by_price($value);
        } else {

            $this->product_detail_by_another($value);
        }

    }

    public function product_detail_by_product($value = null)
    {


        if ($value['status'] == 'false') {


            $product = DB::table('products')
                ->where('products.id', $value['id'])
                ->join('store_products', 'store_products.product_id', '=', 'products.id')
                ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
                ->select(
                    'products.*',
                    'products.text as product',
                    'statuses.name as status',
                    'store_products.quantity as availabe_qty',
                    'store_products.*',
                    'store_products.cost as price',
                    'store_products.id as store_product_id'

                )
                ->get();





            foreach ($product as  $value) {

                $this->data[$this->count] = $value;
                $this->count = $this->count + 1;
            }
        }




        // dd($this->qty->details);
    }

    public function product_detail_by_price($value = null)
    {


        if ($value['status'] == 'false') {


            $product = DB::table('products')
                ->where('products.id', $value['id'])
                ->join('store_products', 'store_products.product_id', '=', 'products.id')
                ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
                ->join('product_units', 'product_units.product_id', '=', 'products.id')
                ->join('units', 'product_units.unit_id', '=', 'units.id')

                ->select(
                    'products.*',
                    'units.name as unit_name',
                    'store_products.id as store_product_id',
                    'product_units.id as product_unit_id',
                    'store_products.desc',
                    'statuses.name',

                )
                ->get();





            foreach ($product as  $value) {

                $this->data[$this->count] = $value;
                $this->count = $this->count + 1;
            }
        }




        // dd($this->qty->details);
    }
    public function product_detail_by_another($value = null)
    {


        if ($value['status'] == 'false') {

            $product = DB::table('products')
                ->where('products.id', $value['id'])
                ->join('store_products', 'store_products.product_id', '=', 'products.id')
                ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
                ->join('stores', 'store_products.store_id', '=', 'stores.id')
                ->select(
                    'products.*',
                    'products.text as product',
                    'stores.text as store',
                    'stores.account_id as store_account_id',
                    'statuses.name as status',
                    'store_products.quantity as availabe_qty',
                    'store_products.*',
                    'store_products.cost as price',
                    'store_products.id as store_product_id'

                )
                ->get();





            foreach ($product as  $value) {

                $this->data[$this->count] = $value;
                $this->count = $this->count + 1;
            }
        }




        // dd($this->qty->details);
    }



    public function product_detail_by_store($value = null)
    {



        if ($value['status'] == 'false') {

            $product = DB::table('products')
                ->where('stores.id', $value['id'])
                ->join('store_products', 'store_products.product_id', '=', 'products.id')
                ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
                ->join('stores', 'store_products.store_id', '=', 'stores.id')
                ->select(
                    'products.*',
                    'products.text as product',
                    'stores.text as store',
                    'stores.account_id as store_account_id',
                    'statuses.name as status',
                    'store_products.quantity as availabe_qty',
                    'store_products.*',
                    'store_products.cost as price',
                    'store_products.id as store_product_id'

                )
                ->get();




            foreach ($product as  $value) {

                $this->data[$this->count] = $value;
                #
                $this->count = $this->count + 1;
            }
        }
    }
}
