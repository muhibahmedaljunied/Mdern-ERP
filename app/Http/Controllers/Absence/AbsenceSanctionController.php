<?php

namespace App\Http\Controllers\Absence;

use App\Repository\StaffSaction\StaffAbsenceSanctionRepository;
use App\Repository\HR\AbsenceSanctionRepository;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\AbsenceSanction;
use App\Services\CoreStaffService;
use App\Models\SanctionDiscount;
use Illuminate\Http\Request;
use App\Models\AbsenceType;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Staff;
use App\Models\StaffSanction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class AbsenceSanctionController extends Controller
{

    public function __construct(
        protected AbsenceSanctionRepository $hr,
        protected CoreStaffService $core,
    ) {}
    public function index()
    {

        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });



        return response()->json([
            'list' => $this->get_absence_sanction(),
            'absence_types' => AbsenceType::all(),
            'staffs' => $staffs,
            'discount_types' => SanctionDiscount::all()
        ]);
    }


    public function absence_sanction_attendance(Request $request)
    {

        // dd(date('l', strtotime('2024-11-19')), '2024-11-19');
        // Tuesday,Thursday,Saturday,Monday,Wednesday,Friday,Sunday

        $array_filter = [];
        $attendances =  DB::table('attendances');

        if ($request->staff_id) {

            $attendances = $attendances->where('staff_id', $request->staff_id);
        }

        $attendances = $attendances->where('attendance_status', 0)
            ->select(
                'attendances.*'
            )->get();

        // dd($attendances);
        // ----------------------------------------------------------------------------------------------------
        foreach ($attendances as $key => $value) {

            if (date('l', strtotime($value->attendance_date)) == $request->absence_type_code) {

                if (!in_array($value->attendance_date, $array_filter)) {

                    $array_filter[$key] =  $value->attendance_date;
                }
            }
        }
        // dd($array_filter);
        // ----------------------------------------------------------------------------------------------------

        $attendances =  DB::table('staff')
            ->addSelect(['attendance' => function (QueryBuilder $builder) use ($array_filter) {
                $builder->from('attendances')
                    ->selectRaw('count(*) as attendance')
                    ->whereColumn('staff.id', 'attendances.staff_id')
                    ->whereIn('attendance_date', $array_filter);
            }])
            ->get();
        // ----------------------------------------------------------------------------------------------------    


        foreach ($attendances as $key => $value) {


            $absence =  DB::table('absence_sanctions')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
                ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                ->where('absence_sanctions.absence_type_id', $request->absence_type_id)
                ->where('absence_sanctions.iteration', $value->attendance)
                ->select(
                    'absence_sanctions.*',
                    'sanction_discounts.*',
                    'absence_types.name as absence_name'
                )->get();
            $value->absence = $absence;
            // dd($absence);
        }

        // ----------------------------------------------------------------------------------------------------
        // dd($attendances);
        return response()->json([
            'list' => $attendances,

        ]);



        // ------------------------------------
        // $array_filter  = ['2024-11-20', '2024-11-19', '2024-11-18'];

        // $attendances = DB::table("staff")

        //     ->select(
        //         "staff.*",

        //         DB::raw(
        //             "(SELECT count(*) FROM attendances WHERE attendances.staff_id = staff.id
        //          AND 
        //          attendances.attendance_date BETWEEN '2024-11-18' AND '2024-11-20') as total_followers"
        //         )
        //     )

        //     ->get();


        // ---------------------------------------------------

        // $attendances = Staff::query()
        //     ->select('*')
        //      ->selectSub(
        //         fn($query) => $query
        //             ->selectRaw('count(attendances.*)')
        //             ->whereIn('attendances.attendance_date', $array_filter)
        //             ->from('attendances')
        //             ->whereColumn('staff.id', 'attendances.staff_id'),
        //         'absence'
        //     )
        //     ->get();

    }
    public function show()
    {


        $absence_sanctions =  DB::table('attendances')
            // ->join('attendance_details', 'attendances.id', '=', 'attendance_details.attendance_id')
            ->select(
                'attendances.*',
                // 'attendance_details.*',
            )

            ->selectRaw('select * from attendance_details')
            ->get();

        dd($absence_sanctions);
    }
    public function get_absence_sanction()
    {


        $absence_sanctions =  DB::table('absence_sanctions')
            ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
            ->select(
                'absence_sanctions.*',
                'absence_types.name as absence',
                'sanction_discounts.name as discount_name'
            )
            ->paginate(10);


        $absence_sanctions = Cache::rememberForever('absence_sanctions_index', function () {

            return DB::table('absence_sanctions')
                ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
                ->select(
                    'absence_sanctions.*',
                    'absence_types.name as absence',
                    'sanction_discounts.name as discount_name'
                )
                ->paginate(10);
        });

        return $absence_sanctions;
    }


    public function get_staff_absence_sanction(Request $request)
    {

        $staff = StaffSanction::with(['Sanctionable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                AbsenceSanction::class => function ($query) {
                    $query->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id');
                    $query->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id');
                    $query->select(
                        'absence_sanctions.*',
                        'absence_types.name as type_name',
                        'sanction_discounts.name as discount_name'
                    );
                },
            ]);
        }])
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->where('sanctionable_type', 'App\\Models\\AbsenceSanction')
            ->select(
                'staff_sanctions.date as sanction_date',
                'staff_sanctions.sanctionable_type',
                'staff_sanctions.sanctionable_id',
                'staff.name',
                'staff.id',
                'staff_sanctions.status'
            )
            ->paginate();

        return response()->json(['list' => $staff]);
    }





    public function store(Request $request)
    {


        // dd($request->all());
        $this->core->data = $request->all();

        foreach ($request->post('count') as $value) {

            $this->core->value = $value;

            $this->hr->handle();

            // }
        }

        Cache::forget('absence_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }


    public function change_status(
        Request $request,
        StaffAbsenceSanctionRepository $staff_sanction,
        PayrollService $payroll
    ) {


        $this->core->data = $request->all();

        try {

            DB::beginTransaction();

            $staff_sanction->update_sanction();

            $payroll->payroll('total_absence_sanction');

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
    }
}
