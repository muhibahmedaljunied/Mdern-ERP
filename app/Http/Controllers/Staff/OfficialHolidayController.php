<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\OfficialHoliday;
use App\Models\VacationType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\CoreStaffService;
class OfficialHolidayController extends Controller
{

    public function __construct(

        protected CoreStaffService $core

    ) {}

    public function index()
    {
        $official_holidays = DB::table('official_holidays')
            ->select('official_holidays.*')
            ->paginate(10);
        return response()->json(['official_holidays' => $official_holidays]);
    }


  


    public function store(Request $request)
    {


        // dd($request->all());
        $this->core->setData($request->all());
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            foreach ($request->post('count') as $value) {

                $staff = new OfficialHoliday();
                $staff->name = $request['holiday'][$value];
                $staff->from_date = $request['start_date'][$value];
                $staff->into_date = $request['end_date'][$value];
                $staff->duration = $request['days'][$value];
                $staff->save();
            }
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "allowance created successfully",
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


    public function show(VacationType $vacationType)
    {
        //
    }

    public function edit(VacationType $vacationType)
    {
        //
    }


    public function update(Request $request, VacationType $vacationType)
    {
        //
    }


    public function destroy(VacationType $vacationType)
    {
        //
    }
}
