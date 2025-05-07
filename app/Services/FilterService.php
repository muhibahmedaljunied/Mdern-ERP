<?php

namespace App\Services;

use App\Models\Product;

class FilterService
{
    public $array_where = [];
    public $array_attribute = [];
    public $group_array_attribute = [];
    public $count = 0;
    public  $product_id;
    public $array_data;
    public $root;
    public $link;


    public $data = [
        [
            "id" => 0,
            "text" => 0,
            "rank" => 0,
            "status" => 0,
            "parent_id" => 0,
        ]

    ];

    function wherefilter()
    {



        $i = 0;
        $i1 = 0;

        // dd($this->array_data['الحجم']);
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

            $this->get_details($value);
        } else {
            $this->foreach_root($value['children']);
        }
    }

    function queryfilter()
    {


        $product = Product::where(function ($query) {

            return $query->where('parent_id', '=', $this->product_id)
                ->orWhere('id', '=', $this->product_id)->where('status', '=', 'false');
        })
            ->with('children')
            ->get();

        $this->root = collect($product)->toArray();
        $this->foreach_root($this->root);
        return $this;
    }



    function get_details($value)
    {


        if ($value['status'] == 'false') {

            $product = Product::where(function ($query) use ($value) {
                return $query->where('products.id', '=', $value['id']);
            })
                ->join('store_products', 'products.id', '=', 'store_products.product_id')
                ->join('statuses', 'store_products.status_id', '=', 'statuses.id')

                // ->select('products.*','store_products.*','store_products.id as store_product_id')
                ->select(
                    'products.*',
                    'products.text as product',
                    'statuses.name as status',
                    'store_products.quantity as availabe_qty',
                    'store_products.*',
                    'store_products.cost as price',
                    'store_products.id as store_product_id'

                )


                // ->with('store_product')
                ->get();

            $this->data[$this->count] = $product[0];
            $this->count = $this->count + 1;
        }
    }
}
