<?php

namespace App\Enums;

enum Days: int
{
    case Friday = 0;
    case Satarday = 1;
    case Sunday = 2;
    case Monday =3 ;
    case Tusday = 4;
    case Wedencday =5 ;
    case Thresay = 6;
    


    public static function values(): array
    {


        $df = array();

        foreach (self::cases() as $key => $value) {
            
            $df[$key]['name'] = $value->name;
            $df[$key]['value'] = $value->value;

        }



        return $df;
        // ["deposit" => "Deposit", "withdraw" => "Withdraw"]
    }


}