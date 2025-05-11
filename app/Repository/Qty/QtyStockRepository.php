<?php

namespace App\Repository\Qty;

use App\Traits\Unit\UnitsTrait;

class QtyStockRepository
{


    use UnitsTrait;
    public $ix = 0;
    public $all_qty;
    public $table;
    public $tables;
    public $qty;
    public $request;
    public $value;
    public $details;
    private $compare_array;
    public $column;
    public $DB;
    public $output;




    public function set_compare_array($arr)
    {

        $this->compare_array = $arr;
    }

    public function handle_qty()
    {


        foreach ($this->details as $value) {

            $this->value = $value;
            $this->units();
            $this->init_qty();
            $this->translate_qty();
        }
    }



    public function init_qty()
    {

        // dd($this->compare_array);
        foreach ($this->compare_array  as $value0) {


            foreach ($this->value->units as $key => $value) {



                $this->qty[$value0] = collect($this->value)->toArray()[$value0];



                $this->all_qty[$value0] = array();
            }
        }
    }

    function translate_qty()
    {



        foreach ($this->compare_array as $value0) {



            if ($this->qty[$value0] != 0) {

                $this->check_qty($value0);
            }
        }

        $this->value->qty_after_convert = $this->all_qty;
    }

    public function check_qty($value0)
    {

        $variable = [];


        foreach ($this->value->units as $key => $value) {


            if ($this->qty[$value0] / $value->rate >= 1) {


                $variable[$key] = $this->qty[$value0] / $value->rate;
            }
        }




        $min = intval(min($variable));

        $keyOfMaxValue = array_keys($variable, min($variable))[0];

        $this->all_qty[$value0][$this->ix] = array(

            [
                $min,
                $this->value->units[$keyOfMaxValue]->name,
            ]


        );




        $this->qty[$value0] = $this->qty[$value0] - ($min * $this->value->units[$keyOfMaxValue]->rate);

        if ($this->qty[$value0] >= 1) {


            $this->ix = $this->ix + 1;
            $this->check_qty($value0);
        }

        // dd($this->qty[$value0]);
    }
}

// --------------------------------------------------


//     public function handle_qty()
//     {


//         foreach ($this->details as $value) {

//             $this->value = $value;
//             $this->units();
//             $this->qty();
//         }
//     }



//     public function qty()
//     {



//         foreach ($this->compare_array  as $value0) {

//             foreach ($this->value->units as $key => $value) {


//                 $this->init_qty($value0, $value);
//                 $result = $this->translate_qty($value0, $value, $key);
//                 if ($result == 1) {
//                     break;
//                 }
//             }
//         }
//     }

//     public function init_qty($value0, $value)
//     {




//         if ($this->value->unit_id) {
//             // dd($this->qty);
//             if ($this->value->unit_id == $value->unit_id) {

//                 $this->qty[$value0] = collect($this->value)->toArray()[$value0] * $value->rate;
//             }
//         } else {

//             $this->qty[$value0] = collect($this->value)->toArray()[$value0];
//         }


//         $this->r[$value0] = array();
//     }


//     function translate_qty($value0, $value, $key)
//     {



//         // foreach ($this->compare_array as $value0) {

//         //     foreach ($this->value->units as $key => $value) {
//         $result = 0;
//         if ($this->value->unit_id) {




//             if ($this->value->unit_id == $value->unit_id) {

//                 return $this->check_qty($value0, $value, $key);
//                 // return $result;
//                 // if ($result == 1) {
//                 //     break;
//                 // }
//             }
//         } else {



//             return $this->check_qty($value0, $value, $key);
//             // return $result
//             // if ($result == 1) {
//             //     break;
//             // }
//             //     }
//             // }


//             // $this->value->qty_after_convert = $this->r[$value0];

//         }


//         // dd($this->r);
//         $this->value->qty_after_convert = $this->r;
//     }


//     public function check_qty($value0, $value, $key)
//     {



//         // dd($this->qty,$value->rate);
//         if ($this->qty[$value0] / $value->rate >= 1) {



//             $this->r[$value0]["$key"] = array(

//                 [
//                     intval($this->qty[$value0] / $value->rate),

//                     $value->name
//                 ]


//             );
//         }

//         if ($this->qty[$value0] % $value->rate >= 1) {

//             $this->qty[$value0] = $this->qty[$value0] % $value->rate;
//         } else {

//             return 1;
//         }
//     }
