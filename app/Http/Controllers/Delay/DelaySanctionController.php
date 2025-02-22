<?php

namespace App\Http\Controllers\Delay;

use App\Exports\DelaySanctionExport;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\SanctionDiscount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\DelaySanctionImport;
use App\Models\DelaySanction;
use Illuminate\Support\Facades\Cache;
use App\Services\CoreStaffService;
use App\Repository\HR\DelaySanctionRepository;
use App\Models\DelayType;
use App\Models\Part;
use App\Models\StaffSanction;
use App\Repository\StaffSaction\StaffDelaySanctionRepository;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DelaySanctionController extends Controller
{





    public function __construct(
        protected DelaySanctionRepository $hr,
        protected CoreStaffService $core,

    ) {}
    public function index()
    {


        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------

        return response()->json([
            'list' => $this->get_delay_sanction(),
            'delay_types' => DelayType::all(),
            'delay_parts' => Part::all(),
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


    // dd(date('l', strtotime('2024-11-19')), '2024-11-19');           
    // Tuesday,Thursday,Saturday,Monday,Wednesday,Friday,Sunday
    // dd($request->all());

    public function delay_sanction_attendance(Request $request)
    {

        $this->filter_date($request);
        // ----------------------------------------------------------------------------------------------------------------
        $this->staff_attendance($request);
        // ----------------------------------------------------------------------------------------------------------------
        $this->final_sanction($request);

        // dd($this->core->attendances);
        return response()->json([
            'list' => $this->core->attendances,

        ]);
    }




    public function filter_date($request)
    {



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

            if ($this->get_day_name("$year-$month-$i") == $request->delay_type_code) {

                $this->core->array_filter[$i] =  $year . '-' . $month . '-' . $i;
            }
        }
    }

    public function staff_attendance($request)
    {



        $this->core->attendances = DB::table('attendances')
            ->select(
                'staff.name',
                'staff.id as staff_id',
                DB::raw('count(attendances.id) as attendance'),
                'revenue',
            )
            ->groupBy(
                'staff.name',
                'staff.id',
                'revenue',
            )
            ->Join(
                DB::raw('(SELECT attendance_id,SUM(delay) AS revenue FROM attendance_details 
                GROUP BY attendance_id) AS n'),
                'n.attendance_id',
                '=',
                'attendances.id'
            )
            ->where('revenue', $request->delay_part_duration)
            ->whereIn('attendance_date', $this->core->array_filter)
            ->join('staff', 'staff.id', '=', 'attendances.staff_id');

        if (count($request->staff_id) > 0) {

            $this->core->attendances = $this->core->attendances->where('staff.id', $request->staff_id[0]);
        }
        $this->core->attendances = $this->core->attendances->orderBy('revenue')
            ->paginate();



        // dd($this->core->attendances);
    }




    public function final_sanction($request)
    {

        // dd($request->delay_type_id);

        foreach ($this->core->attendances as $value) {





            $delay =  collect(DelaySanction::join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
                ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
                ->where('delay_sanctions.part_id', $request->delay_part_id)
                ->where('delay_sanctions.delay_type_id', $request->delay_type_id)
                ->where('delay_sanctions.iteration', $value->attendance)
                ->select(
                    'delay_sanctions.*',
                    'sanction_discounts.name',
                    'delay_types.name as delay_name'
                )
                ->get())->toArray();



            if (count($delay) > 0) {


                foreach ($delay as $key => $value2) {

                    $staff_sanction =  collect(StaffSanction::where('sanctionable_type', 'App\Models\DelaySanction')
                        ->where('sanctionable_id', $value2['id'])
                        ->where('staff_id', $value->staff_id)
                        ->select(
                            '*'
                        )
                        ->get())->toArray();



                    if (count($staff_sanction) > 0) {   //if found staff_sanction do not return sanction

                        $value->staff_sanction[$key] = $staff_sanction;
                    } else {

                        $value->delay[$key] = $value2;
                    }
                }
            }


            // if (count(collect($delay)->toArray()) > 0) {

            //     $value->delay = $delay;
            // }
        }



        // foreach ($this->core->attendances as $value) {

        //     $delay =  DelaySanction::with(['staff_sanction' => function ($query) use ($request) {

        //         $query->where('staff_sanctions.sanctionable_type', 'App\Models\DelaySanction')->select('*');
        //     }])
        //         ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
        //         ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
        //         ->where('delay_sanctions.part_id', $request->delay_part_id)
        //         ->where('delay_sanctions.delay_type_id', $request->delay_type_id)
        //         ->where('delay_sanctions.iteration', $value->attendance);

        //     $delay = $delay->select(
        //         'delay_sanctions.*',
        //         'sanction_discounts.*',
        //         'delay_types.name as delay_name'
        //     )
        //         ->get();

        //     $value->part = $request->delay_part_duration;

        //     if (count(collect($delay)->toArray()) > 0) {

        //         $value->delay = $delay;
        //     }
        // }

        // dd(count(collect($delay)->toArray()));
    }


    public function apply_delay_sanction_attendance(Request $request)
    {



        // dd($request->sanction);
        // unset( $array_name['key_to_be_removed'] );
        foreach ($request->sanction as $value) {

            $delay = new StaffSanction();
            $delay->staff_id = $request->staff_id;
            $delay->sanctionable()->associate(DelaySanction::find($value['id']));
            $delay->date = $request->date;
            $delay->save();
        }





        // dd($request->all());
        return response()->json([
            'status' => 'successfully',

        ]);
    }

    public function get_delay_sanction()
    {


        $delay_sanctions =  DB::table('delay_sanctions')
            ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
            ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
            ->select(
                'delay_sanctions.*',
                'delay_types.name as delay',
                'parts.name as duration',
                'sanction_discounts.name as discount_name'
            )
            ->paginate(10);

        // ----------------------------------------------------------------------------------------
        // $delay_sanctions = Cache::rememberForever('delay_sanctions_index', function () {

        $delay_sanctions = DB::table('delay_sanctions')
            ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
            ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
            ->select(
                'delay_sanctions.*',
                'delay_types.name as delay',
                'parts.name as duration',
                'sanction_discounts.name as discount_name'
            )
            ->paginate(10);
        // });

        return $delay_sanctions;
    }


    public function get_staff_delay_sanction(Request $request)
    {


        $staff = StaffSanction::with(['Sanctionable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                DelaySanction::class => function ($query) {
                    $query->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id');
                    $query->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id');
                    $query->join('parts', 'parts.id', '=', 'delay_sanctions.part_id');
                    $query->select(
                        'delay_sanctions.*',
                        'delay_types.name as type_name',
                        'parts.name as part_name',
                        'sanction_discounts.name as discount_name'
                    );
                },
            ]);
        }])
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->where('sanctionable_type', 'App\\Models\\DelaySanction')
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

    public function import(Request $request)
    {

        Excel::import(new DelaySanctionImport, storage_path('delay_sanction.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported'
        ]);
    }


    public function export()
    {

        Excel::download(new DelaySanctionExport, 'delay_sanction.xlsx');


        return response()->json([
            'status' =>
            'The file has been excel/csv exporteded'
        ]);
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

        Cache::forget('delay_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }

    public function change_status(
        Request $request,
        StaffDelaySanctionRepository $staff_sanction,
        PayrollService $payroll
    ) {

        // dd($request->all());
        $this->core->data = $request->all();

        try {

            DB::beginTransaction();

            $staff_sanction->update_sanction();

            $payroll->payroll('total_delay_sanction');



            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Delay Created Successfully",
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
