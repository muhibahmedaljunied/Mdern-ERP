<?php

namespace App\Traits;

use App\Models\StoreProduct;
use Illuminate\Support\Facades\DB;

trait StoreProductTrait
{



  public function productCodeExists($number)
  {
    return StoreProduct::whereProductCode($number)->exists();
  }


  public function barecode()
  {


    $number = mt_rand(1000000000, 9999999999);

    if ($this->productCodeExists($number)) {
      $number = mt_rand(1000000000, 999999999);
    }

    // dd($number);
    return $number;
  }
  public function init_store_product_table()
  {

    $this->core->data_store_product = new StoreProduct();
    $this->core->data_store_product->product_id = $this->core->data['product'][$this->core->value];
    $this->core->data_store_product->product_code = $this->barecode();
    $this->core->data_store_product->store_id = $this->core->data['store'][$this->core->value];
    $this->core->data_store_product->status_id = $this->core->data['status'][$this->core->value];
    $this->core->data_store_product->desc = $this->core->data['desc'][$this->core->value];
    $this->core->data_store_product->quantity = $this->core->micro_unit_qty;
    $this->core->data_store_product->cost = $this->core->data['total'][$this->core->value] / $this->core->micro_unit_qty;
    $this->core->data_store_product->total = $this->core->data['total'][$this->core->value];
    $this->core->data_store_product->save();
    $this->core->id_store_product =  $this->core->data_store_product->id;
  }


  public function refresh_qty_store_product_table($operation = null)
  {




    $operation = $this->operation;


    $this->core->store_product_f =  DB::table('store_products')
      ->where(['id' => $this->core->id_store_product])
      ->$operation('quantity', $this->core->micro_unit_qty);

    // dd($this->core->store_product_f);
  }

  public function refresh_total_store_product_table($operation = null)
  {




    $operation = $this->operation;

    $this->core->store_product_f =  DB::table('store_products')
      ->where(['id' => $this->core->id_store_product])
      ->$operation('total', $this->core->data['total'][$this->core->value]);

    // dd(intval(StoreProduct::find($this->core->id_store_product)->total));



  }


  public function refresh_cost_store_product_table()
  {


    // dd($this->core->data_store_product[0]['total'] , $this->core->data_store_product[0]['quantity'],($this->core->data_store_product[0]['total'] / $this->core->data_store_product[0]['quantity']));
    if ($this->core->data_store_product[0]['total'] == 0 || $this->core->data_store_product[0]['quantity'] == 0) {

      DB::table('store_products')
        ->where(['id' => $this->core->data_store_product[0]['id']])
        ->update(['cost' => $this->core->data_store_product[0]['total']]);
    } else {


      DB::table('store_products')
        ->where(['id' => $this->core->data_store_product[0]['id']])
        ->update(['cost' => ($this->core->data_store_product[0]['total'] / $this->core->data_store_product[0]['quantity'])]);
    }

    // dd($this->core->data_store_product[0]['total']);
  }



  function get_store_product_first()
  {


    // dd('we',$this->core);
    $this->core->data_store_product =  collect(StoreProduct::where([
      'store_products.id' => $this->core->data['old'][$this->core->value]['store_product_id'],

    ])
      ->select()
      ->get())->toArray();



    $this->core->id_store_product = ($this->core->data_store_product == null) ? 0 : $this->core->data_store_product[0]['id'];


    return $this;
  }


  function get_store_product_tow()
  {


    // dd($this->core->data);

    $this->core->data_store_product = collect(StoreProduct::where([
      'product_id' => $this->core->data['product'][$this->core->value],
      'store_id' => $this->core->data['store'][$this->core->value],
      'status_id' => $this->core->data['status'][$this->core->value],
      'desc' => $this->core->data['desc'][$this->core->value]
    ])
      ->select()
      ->get())->toArray();

    $this->core->id_store_product = ($this->core->data_store_product == null) ? 0 : $this->core->data_store_product[0]['id'];
  }




  // function get_store_product_one_table()
  // {



  //     $this->core->data_store_product = collect(StoreProduct::where([
  //         'product_id' => $this->core->data['product'][$this->core->value],
  //         'store_id' => $this->core->data['store'][$this->core->value],
  //         'status_id' => $this->core->data['status'][$this->core->value],
  //         'desc' => $this->core->data['desc'][$this->core->value]
  //     ])
  //         ->select()
  //         ->get())->toArray();


  //     $this->core->id_store_product = ($this->core->data_store_product == null) ? 0 : $this->core->data_store_product[0]['id'];
  // }


  // function get_store_product_tow_table()
  // {

  //     $this->core->data_store_product  = collect(StoreProduct::where([
  //         'store_products.id' => $this->core->data['old'][$this->core->value]['store_product_id'],

  //     ])
  //         ->select()
  //         ->get())->toArray();

  //     // dd($this->core->data_store_product);

  //     $this->core->id_store_product = ($this->core->data_store_product == null) ? 0 : $this->core->data_store_product[0]['id'];
  // }
}
