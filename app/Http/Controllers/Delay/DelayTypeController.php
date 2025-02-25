<?php

namespace App\Http\Controllers\Delay;
use App\Http\Controllers\Controller;
use App\Services\Staff\DelayService;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\DelayRepository;
use App\Services\CoreStaffService;
use App\Models\DelayType;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class DelayTypeController extends Controller
{

    public function __construct(

     
        protected CoreStaffService $core,
        protected DelayRepository $hr,



    ) {
    }

    public function index()
    {


        $Delays = staff::with(['Delay', 'Delay.Delay_type'])->paginate(10);
        $this->hr->Sum($Delays, 'Delay');

        // dd($Delays);
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return response()->json([
            'Delay_types' => DelayType::all(),
            // 'Delay_parts' => DelayPart::all(),
            'staffs' => Staff::all(),
            'list' => $Delays
        ]);
    }


    
    public function delay_type()
    {

        return response()->json([
            'delay_types' => DelayType::all(),
   
        ]);
    }


    public function store(Request $request)
    {




        // dd($request->all());
        foreach ($request->post('count') as $value) {

            $work_systm = new DelayType();
            $work_systm->name = $request->post('name')[$value];
            $work_systm->code = $request->post('code')[$value];
            $work_systm->save();
        }
        response()->json();
    }

    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['Delay', 'Delay.Delay_type'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }

 

   


    public function destroy($id)
    {

        // DB::table('payrolls')->where('staff_id', '=', $id)->delete();

        // $store = staff::find($id);

        // $store->delete();

        // Cache::forget('staff');



        return response()->json('successfully deleted');
    }

  
}
