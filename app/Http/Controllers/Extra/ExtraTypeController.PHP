<?php

namespace App\Http\Controllers\Extra;
use App\Http\Controllers\Controller;
use App\Services\Staff\ExtraService;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\ExtraRepository;
use App\Services\CoreStaffService;
use App\Models\ExtraType;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class ExtraTypeController extends Controller
{

    public function __construct(

     
        protected CoreStaffService $core,
        protected ExtraService $extra_sanction,
        protected ExtraRepository $hr,



    ) {
    }

    public function index()
    {


        $extras = staff::with(['extra', 'extra.extra_type'])->paginate(10);
        $this->hr->Sum($extras, 'extra');

        // dd($extras);
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return response()->json([
            'extra_types' => ExtraType::all(),
            // 'extra_parts' => ExtraPart::all(),
            'staffs' => Staff::all(),
            'list' => $extras
        ]);
    }


    
    public function extra_type()
    {

        return response()->json([
            'extra_types' => ExtraType::all(),
            // 'groups' =>$this->groups()
        ]);
    }


    public function store(Request $request)
    {



        foreach ($request->post('count') as $value) {

            $work_systm = new ExtraType();
            $work_systm->name = $request->post('name')[$value];
            $work_systm->code = $request->post('code')[$value];
            $work_systm->save();
        }

        response()->json();
    }

    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['extra', 'extra.extra_type'])->paginate(10);

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
