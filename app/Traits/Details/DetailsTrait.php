<?php

namespace App\Traits\Details;

use Illuminate\Support\Facades\DB;
use App\Traits\Unit\UnitsTrait;

trait DetailsTrait
{
    use UnitsTrait;



    public function init()
    {


        $this->qty->table = $this->qty->request['table'];

        $this->qty->output = explode('_', $this->qty->table);


        if ($this->qty->table == 'opening_inventuries') {


            $this->qty->column = $this->qty->output[0] . '_' . $this->qty->output[1];
            $this->qty->DB = DB::raw($this->qty->table . '.qty');

        } else {

            if (str_contains($this->qty->table, '_return_')) {


                $this->qty->column = $this->qty->output[0] . '_' . $this->qty->output[1];
                $this->qty->DB = DB::raw($this->qty->table . '.qty');
            } else {
                // dd($this->qty->output);
                $this->qty->column = $this->qty->output[0];
                $this->qty->DB = DB::raw($this->qty->table . '.qty-' . $this->qty->table . '.qty_return AS qty_remain');
            }

            // dd($this->qty->DB);
        }
    }



    public function get_details()
    {





        $this->qty->details =   DB::table($this->qty->table);

        if ($this->qty->request->id) {
            
            $this->qty->details = $this->qty->details->where($this->qty->table . '.' . $this->qty->column . '_id', $this->qty->request->id);
        }

        $this->qty->details = $this->qty->details->join('store_products', 'store_products.id', '=', $this->qty->table . '.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            // ->where('store_products.quantity','>',0)

            ->select(
                'products.*',
                'products.text as product',
                $this->qty->table . '.*',
                'store_products.*',
                'statuses.name as status',
                'stores.text as store',
                'stores.account_id as store_account_id',
                'store_products.quantity as avilable_qty',
                'store_products.desc',
                $this->qty->DB

            )
            ->get();

        // dd($this->qty->details);

        foreach ($this->qty->details as $value) {

            $value->qty_return_now = 0;


            $value->unit_selected = [];
        }
    }
    public function get_return_details()
    {


        $this->qty->details = DB::table($this->qty->table)
            ->where($this->qty->table . '.' . $this->qty->output[0] . '_return_id', $this->qty->request->id)
            ->join(
                $this->qty->output[0] . '_returns',
                $this->qty->output[0] . '_returns.id',
                '=',
                $this->qty->table . '.' . $this->qty->output[0] . '_return_id'
            )
            ->join('store_products', 'store_products.id', '=', $this->qty->table . '.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->select(
                'store_products.*',
                $this->qty->table . '.*',
                'products.*',
                $this->qty->table . '.qty as qty_return',
                $this->qty->output[0] . '_returns.*',
                'statuses.*',
                'statuses.name as status',
                'stores.*',
                'products.text as product_name'
            )
            ->get();
    }
}
