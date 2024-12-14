<?php

namespace App\Http\Controllers\Account;


use App\Models\Currency;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class CurrencyController extends Controller
{
    
   
    public function index()
    {

       

        $currencies = Currency::all();
        return response()->json(['currencies' => $currencies]);
    }

    public function store(Request $request)
    {


   

        foreach ($request->post('count') as $value) {
     
           
            $currency = new Currency();
            $currency->name =  $request->post('name')[$value];
            $currency->symbole =  $request->all()['symbole'][$value];
            $currency->rate =  $request->all()['rate'][$value];
            $currency->save();
            
           

        }
     
        return response()->json(['message' => 'success']);
    }

    
    public function create()
    {
        //
    }

    

    public function show()
    {
         $currencies = DB::table('currencies')
        ->select('currencies.*')
        ->paginate(10);

        return response()->json(['currencies' => $currencies]);
    }

    
    public function edit()
    {
        //
    }

    
    public function update()
    {
        //
    }

   
    public function destroy()
    {
        //
    }
}
