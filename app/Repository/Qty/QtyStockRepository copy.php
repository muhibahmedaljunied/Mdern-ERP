<?php

namespace App\Repository\Qty;

use App\Traits\Unit\UnitsTrait;

class QtyStockRepository
{


    use UnitsTrait;
    public $r;
    public $qty;
    public $value;
    public $details;
    public $compare_array;



    public function handle_qty()
    {


        foreach ($this->details as $value) {

            // dd($value);
            $this->value = $value;
            $this->units();
            $this->init_qty();
            $this->translate_qty();
        }
    }



    public function init_qty()
    {


       


        foreach ($this->compare_array  as $value0) {

           
            foreach ($this->value->units as $key => $value) {

                // dd($this->value->unit_id); qty_remain
                if ($this->value->unit_id && $value0 != 'quantity' ) {

                    if ($this->value->unit_id == $value->unit_id) {

                        $this->qty[$value0] = collect($this->value)->toArray()[$value0] * $value->rate;
                        
                    }

                } else {

                    $this->qty[$value0] = collect($this->value)->toArray()[$value0];
                
                }

                $this->r[$value0] = array();
            }
        }
    }

    function translate_qty()
    {



        foreach ($this->compare_array as $value0) {

            if ($this->value->unit_id && $value0 != 'quantity') {


                $this->loop_unit_with_unit_id($value0);
            } else {


                $this->loop_unit_without_unit_id($value0);
            }


            // $this->value->qty_after_convert = $this->r[$value0];

        }


        $this->value->qty_after_convert = $this->r;
    }


    public function loop_unit_with_unit_id($value0)
    {

        foreach ($this->value->units as $key => $value) {

            $result = 0;

            if ($this->value->unit_id == $value->unit_id) {

                $result = $this->check_qty($value0, $value, $key);
                if ($result == 1) {
                    break;
                }
            }
        }
    }


    public function loop_unit_without_unit_id($value0)
    {

        foreach ($this->value->units as $key => $value) {

            $result = 0;
            $result = $this->check_qty($value0, $value, $key);
            if ($result == 1) {
                break;
            }
        }
    }

    public function check_qty($value0, $value, $key)
    {



        if ($this->qty[$value0] / $value->rate >= 1) {



            $this->r[$value0]["$key"] = array(

                [
                    intval($this->qty[$value0] / $value->rate),

                    $value->name
                ]


            );
        }

        if ($this->qty[$value0] % $value->rate >= 1) {

            $this->qty[$value0] = $this->qty[$value0] % $value->rate;
        } else {

            return 1;
        }
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



