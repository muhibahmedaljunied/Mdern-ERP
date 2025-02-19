<?php

namespace App\Http\Controllers\Absence;

use App\Events\TestEvent;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\AbsenceRepository;
use App\Services\CoreStaffService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\Staff\AbsenceService;
use App\Models\AbsenceType;
use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Attendance;
use App\Models\SanctionDiscount;
use App\Models\Staff;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct(

        protected CoreStaffService $core,
        protected AbsenceService $absence_sanction,
        protected AbsenceRepository $hr,



    ) {}


    public function test()
    {
        // return 111;
        event(new TestEvent('One Click'));
        return response()->json(['absence_types' => 'Hooray!!! You have fired your Event successfully']);
    }


    public function index()
    {


        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return response()->json([
            'absence_types' => AbsenceType::all(),
            'staffs' => $staffs,
            'discount_types' => SanctionDiscount::all()
        ]);
    }



    public function absence_type()
    {


        return response()->json([
            'absence_types' => AbsenceType::all(),
            // 'groups' => $this->groups(),
        ]);
    }

    // public function groups()
    // {



    //     return DB::table('groups')
    //         ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
    //         ->where('group_types.code', 'absence')
    //         ->select(
    //             'groups.*',
    //             'group_types.name as type_name'
    //         )
    //         ->get();
    // }



    public function get_staff_absence()
    {

        // $minutes = 60;
        $staffs =  DB::table('absences')
            ->join('absence_types', 'absence_types.id', '=', 'absences.absence_type_id')
            ->join('staff', 'staff.id', '=', 'absences.staff_id')
            ->select(
                'staff.name as staff_name',
                'staff.id as staff_id',
                'absences.id as absence_id',
                'absences.date',
                'absence_types.name as absence_type_name',

            )
            ->paginate();

        return response()->json([
            'absence_types' => AbsenceType::all(),
            'staffs' => Staff::all(),
            'list' => $staffs,
        ]);
    }




    public function store(Request $request)
    {


        dd($request->all());
        $this->core->data = $request->all();

        try {

            DB::beginTransaction();
            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);

                // $this->hr->store();  //this with sanction 
                if (
                    $this->core->data['staff'][$this->core->value] == 0
                    // || $this->core->data['absence_type'][$this->core->value] != 0
                ) {

                    $this->handle_all_staff();
                } else {

                    $this->handle_detected_staff();
                }
                // $this->absence_sanction->create();

            }

            // dd('final');
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Absence Created Successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
        // return response()->json(['message' => $we]);
    }

    public function handle_all_staff()
    {


        $staff = Staff::all('id');

        foreach ($staff as $value) {


            Attendance::updateOrCreate(
                [
                    'staff_id' => $value->id,
                    'attendance_date' => $this->core->data['date'][$this->core->value],
                    'attendance_status' => 0,
                    'attendance_final' => 'pendding'

                ]
            );

            Absence::updateOrCreate(
                [
                    'staff_id' => $value->id,
                    'absence_type_id' => $this->core->data['absence_type'][$this->core->value],
                    'date' => $this->core->data['date'][$this->core->value],
                    'note' => ''
    
                ]
            );


        }
    }


    public function handle_detected_staff()
    {



        Attendance::updateOrCreate(
            [
                'staff_id' => $this->core->data['staff'][$this->core->value],
                'attendance_date' => $this->core->data['date'][$this->core->value],
                'attendance_status' => 0,
                'attendance_final' => 'pendding'

            ]
        );

        Absence::updateOrCreate(
            [
                'staff_id' => $this->core->data['staff'][$this->core->value],
                'absence_type_id' => $this->core->data['absence_type'][$this->core->value],
                'date' => $this->core->data['date'][$this->core->value],
                'note' => ''

            ]
        );

    }
}
