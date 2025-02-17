<?php

namespace App\Http\Controllers\Sale;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
USE App\Services\GroupService;
class CustomerGroupController extends Controller
{
    public $groups;
    public $type;
    use GroupService;

    public function init($type)
    {


        $this->type = $type;
    }
    public function index()
    {

        $groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'customer')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();

        return response()->json(['groups' => $groups]);
    }

    public function get_mark_customer()
    {


   
        $this->init('customer');
        $this->groups();
        $groups =  DB::table('customers')
            ->join('groups', 'groups.id', '=', 'customers.group_id')
            ->select(
                'customers.id as customer_id',
                'customers.name as customer_name',
                'groups.*'
            )
            ->paginate();
        return response()->json([
            'group_lists' => $groups,
            'groups' => $this->groups,
            'customers' => Customer::all(),
        ]);
    }
}
