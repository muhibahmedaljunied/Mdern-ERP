<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

use App\Traits\Staff\BasicData\StoreTrait;

use App\Models\AllowanceType;
use App\Services\CoreStaffService;
use App\Services\Staff\StaffService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllowanceTypeController extends Controller
{

    use StoreTrait;

    public function __construct(

        protected CoreStaffService $core

    ) {}


    public function index()
    {


        $groups = $this->groups();
        $allowance_types = AllowanceType::all();
        return response()->json([
            'allowance_types' => $allowance_types,
            'groups' => $groups
        ]);
    }

    public function groups()
    {


        return DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'allowance')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StaffService $staff_service)
    {

        $this->core->setData($request->all());
        // dd($request->all());
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            foreach ($request->post('count') as $value) {

                // $this->core->setValue($value);

                // $staff_service->add_account();

                $staff = new AllowanceType();
                $staff->name = $request['name'][$value];
                $staff->status = $request['status'][$value];
                $staff->group_id = $request['group'][$value];
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



    public function show(AllowanceType $allowance) {}


    public function edit(AllowanceType $allowance)
    {
        //
    }


    public function update(AllowanceType $allowance)
    {
        //
    }


    public function destroy(AllowanceType $allowance)
    {
        //
    }
}
