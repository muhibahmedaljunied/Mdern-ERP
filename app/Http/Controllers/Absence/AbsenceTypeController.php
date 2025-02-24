<?php

namespace App\Http\Controllers\Absence;
use App\Http\Controllers\Controller;
use App\Services\Staff\AbsenceService;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\AbsenceRepository;
use App\Services\CoreStaffService;
use App\Models\AbsenceType;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class AbsenceTypeController extends Controller
{

    public function __construct(

     
        protected CoreStaffService $core,
        protected AbsenceService $Absence_sanction,
        protected AbsenceRepository $hr,



    ) {
    }

    public function index()
    {


        $Absences = staff::with(['Absence', 'Absence.Absence_type'])->paginate(10);
        $this->hr->Sum($Absences, 'Absence');

        // dd($Absences);
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return response()->json([
            'Absence_types' => AbsenceType::all(),
            // 'Absence_parts' => AbsencePart::all(),
            'staffs' => Staff::all(),
            'list' => $Absences
        ]);
    }


    
    public function absence_type()
    {

        return response()->json([
            'absence_types' => AbsenceType::all(),
           
        ]);
    }


    public function store(Request $request)
    {




        dd($request->all());
        foreach ($request->post('count') as $value) {

            $work_systm = new AbsenceType();
            $work_systm->name = $request->post('name')[$value];
            $work_systm->code = $request->post('code')[$value];
            $work_systm->save();
        }
        response()->json();
    }

    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['Absence', 'Absence.Absence_type'])->paginate(10);

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
