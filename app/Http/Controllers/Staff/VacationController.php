<?php

namespace App\Http\Controllers\Staff;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Services\CoreStaffService;
use App\Repository\HR\VacationRepository;
use App\Models\VacationType;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\StaffType;
use Illuminate\Support\Facades\DB;

class VacationController extends Controller
{


    public function __construct(
        protected CoreStaffService $core,
        protected VacationRepository $hr,
    ) {
    }

    public function index()
    {

        $vacations = staff::with(['vacation', 'vacation.vacation_type'])->paginate(10);
        $this->hr->Sum($vacations, 'vaction');

        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------


        $vacation_types = VacationType::all();
        return response()->json([
            'list' => $vacations,
            'branches' => Branch::all(),
            'staff_types' => StaffType::all(),
            'staffs' => $staffs,
            'vacation_types' => $vacation_types
        ]);
    }

    public function report(Request $request){

        
        $vacations = Staff::with(['vacation' => function ($query) use ($request) {
            $query->select('vacations.*')
            ->where('vacations.staff_id','=', $request->staff)
            ->whereBetween('vacations.date', array($request->post('from_date'), $request->post('into_date')));

        }])
        ->select('*')
        ->paginate(10);
        // dd($advances);
        $this->hr->Sum($vacations);

        // dd($advances);
        return response()->json(['list' => $vacations]);


    }

    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['vacation', 'vacation.vacation_type'])->paginate(10);
        return response()->json(['list' => $staffs]);
    }

    public function store(Request $request)
    {


        $this->core->data = $request->all();

       

        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {
                $this->core->setValue($value);
                $this->init_data_store();
                $this->hr->handle();

            }
     
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "purchase created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }

        return response()->json(['message' => $request->all()]);
    }

    public function destroy($id)
    {

        // DB::table('payrolls')->where('staff_id', '=', $id)->delete();

        // $store = staff::find($id);

        // $store->delete();

        // Cache::forget('staff');



        return response()->json('successfully deleted');
    }

    public function init_data_store()
    {


        $this->hr->staff_id = $this->core->data['staff'][$this->core->value];
        $this->hr->vacation_type_id = $this->core->data['vaction_type'][$this->core->value];
        $this->hr->start_date = $this->core->data['start_date'][$this->core->value];
        $this->hr->end_date = $this->core->data['end_date'][$this->core->value]; 
        $this->hr->duration = $this->core->data['days'][$this->core->value];

    }


   
}
