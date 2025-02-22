<?php

namespace App\Http\Controllers\Absence;

use App\Exports\AbsenceSanctionExport;
use App\Repository\StaffSaction\StaffAbsenceSanctionRepository;
use App\Repository\HR\AbsenceSanctionRepository;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Imports\AbsenceSanctionImport;
use App\Models\AbsenceSanction;
use App\Services\CoreStaffService;
use App\Models\SanctionDiscount;
use Illuminate\Http\Request;
use App\Models\AbsenceType;
use App\Models\StaffSanction;
use Maatwebsite\Excel\Facades\Excel;

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

    function get_day_name($date)
    {
        // Convert the date to a timestamp
        $timestamp = strtotime($date);
        // Return the day name
        return date('D', $timestamp);
    }
    public function absence_sanction_attendance(Request $request)
    {

        // dd($request->all());

        // dd(date('l', strtotime('2024-11-19')), '2024-11-19');
        // Tuesday,Thursday,Saturday,Monday,Wednesday,Friday,Sunday
        $this->filter_date($request);
        // ----------------------------------------------------------------------------------------------------------------
        $this->staff_attendance($request);
        // ----------------------------------------------------------------------------------------------------------------
        $this->final_sanction($request);
        // ----------------------------------------------------------------------------------------------------
        // dd($this->core->attendances);
        return response()->json([
            'list' => $this->core->attendances,

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
    public function import(Request $request)
    {

        Excel::import(new AbsenceSanctionImport, storage_path('absence_sanction.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported'
        ]);
    }


    public function export()
    {

        Excel::download(new AbsenceSanctionExport, 'absence_sanction.xlsx');


        return response()->json([
            'status' =>
            'The file has been excel/csv exporteded'
        ]);
    }
    public function apply_absence_sanction_attendance(Request $request)
    {

        // dd($request->all());
        // unset( $array_name['key_to_be_removed'] );
        foreach ($request->sanction as $value) {

            // AbsenceSanction::find($value->id);
            // dd($value);
            $absence = new StaffSanction();
            $absence->staff_id = $request->staff_id;
            $absence->sanctionable()->associate(AbsenceSanction::find($value['id']));
            $absence->date = $request->date;
            $absence->save();
        }





        // dd($request->all());
        return response()->json([
            'status' => 'successfully',

        ]);
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

        // dd($absence_sanctions);
    }



    public function filter_date($request)
    {

        // $date = collect($request->date)->toArray();






        // $year = date("Y"); 

        $request->staff_id = collect($request->staff_id)->toArray();
        $this->core->array_filter = [];

        if (!$request->date) {

            $year = intval(date("Y"));
            $month = intval(date('m'));
        } else {

            $all_date = explode('-', $request->date);
            $year = $all_date[0];
            $month = $all_date[1];
            // echo "Day: $day, Month: $month, Year: $year";

        }


        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);



        for ($i = 1; $i < $days; $i++) {

            if ($this->get_day_name("$year-$month-$i") == $request->absence_type_code) {

                $this->core->array_filter[$i] =  $year . '-' . $month . '-' . $i;
            }
        }

        // dd($this->core->array_filter);
    }


    public function staff_attendance($request)
    {



        $this->core->attendances = DB::table('attendances')
            ->select(
                'staff.name',
                'staff.id as staff_id',
                DB::raw('count(attendances.id) as attendance'),

            )
            ->groupBy(
                'staff.name',
                'staff.id',

            )


            ->whereIn('attendance_date', $this->core->array_filter)
            ->join('staff', 'staff.id', '=', 'attendances.staff_id');

        if (count($request->staff_id) > 0) {

            $this->core->attendances = $this->core->attendances->where('staff.id', $request->staff_id[0]);
        }

        $this->core->attendances = $this->core->attendances->paginate();



        // dd($this->core->attendances);
    }




    public function final_sanction($request)
    {

        // dd($request->absence_type_id);
        foreach ($this->core->attendances as $value) {





            $absence =  collect(AbsenceSanction::join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
                ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                ->where('absence_sanctions.absence_type_id', $request->absence_type_id)
                ->where('absence_sanctions.iteration', $value->attendance)
                ->select(
                    'absence_sanctions.*',
                    'sanction_discounts.name',
                    'absence_types.name as absence_name'
                )
                ->get())->toArray();



            if (count($absence) > 0) {


                foreach ($absence as $key => $value2) {

                    $staff_sanction =  collect(StaffSanction::where('sanctionable_type', 'App\Models\AbsenceSanction')
                        ->where('sanctionable_id', $value2['id'])
                        ->where('staff_id', $value->staff_id)
                        ->select(
                            '*'
                        )
                        ->get())->toArray();



                    if (count($staff_sanction) > 0) {   //if found staff_sanction do not return sanction

                        $value->staff_sanction[$key] = $staff_sanction;
                    } else {

                        $value->absence[$key] = $value2;
                    }
                }
            }
        }

        // dd($this->core->attendances);
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

        // ----------------------------------------------------------------------------------------
        // $absence_sanctions = Cache::rememberForever('absence_sanctions_index', function () {

        $absence_sanctions =  DB::table('absence_sanctions')
            ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
            ->select(
                'absence_sanctions.*',
                'absence_types.name as absence',
                'sanction_discounts.name as discount_name'
            )
            ->paginate(10);
        // });

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
