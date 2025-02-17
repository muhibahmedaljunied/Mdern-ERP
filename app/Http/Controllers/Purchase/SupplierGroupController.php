<?php

namespace App\Http\Controllers\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\GroupService;
use Storage;

class SupplierGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
            ->where('group_types.code', 'supplier')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();

        return response()->json(['groups' => $groups]);
    }


    public function get_mark_supplier()
    {


        $this->init('supplier');
        $this->groups();

        $groups =  DB::table('suppliers')
            ->join('groups', 'groups.id', '=', 'suppliers.group_id')
            ->select(
                'suppliers.id as supplier_id',
                'suppliers.name as supplier_name',
                'groups.*'
            )
            ->paginate();
        return response()->json([
            'group_lists' => $groups,
            'groups' => $this->groups,
            'suppliers' => Supplier::all(),
        ]);
    }
}
