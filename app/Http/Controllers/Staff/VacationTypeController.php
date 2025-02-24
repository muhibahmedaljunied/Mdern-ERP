<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Models\VacationType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VacationTypeController extends Controller
{

    use StoreTrait;
    public function index()
    {
        $vacation_types = DB::table('vacation_types')
        ->select('vacation_types.*')
        ->paginate(10);
    return response()->json( ['vacation_types'=>$vacation_types]);
    }


    public function vacation_type()
    {

        return response()->json([
            'vacation_types' => VacationType::all(),
        ]);
    }


    public function store(Request $request)
    {


        foreach ($request->post('count') as $value) {

            $work_systm = new VacationType();
            $work_systm->name = $request->post('name')[$value];
            $work_systm->duration = $request->post('duration')[$value];
            $work_systm->save();
        }
        response()->json();
    }

   

  

}
