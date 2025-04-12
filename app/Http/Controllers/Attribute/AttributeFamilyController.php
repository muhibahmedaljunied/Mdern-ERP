<?php

namespace App\Http\Controllers\Attribute;

use App\Models\AttributeFamily;
use App\Models\AttributeFamilyMapping;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeFamilyController extends Controller
{

    public function index(Request $request)
    {

        $attributes = Attribute::all();

        return response()->json([
            'attributes' => $attributes,

        ]);
    }


    public function get_attribute()
    {

        $attributes = Attribute::all();

        return response()->json([
            'attributes' => $attributes,

        ]);
    }

    public function get_family_attribute()
    {



        return response()->json([
            'attribute_families' => AttributeFamily::all(),

        ]);
    }




    public function store(Request $request)
    {

        $family = new AttributeFamily();
        $family->name = $request->post('name');
        $family->code = $request->post('code');
        $family->save();


        foreach ($request['items'] as $value) {

            $AFM = new AttributeFamilyMapping();
            $AFM->attribute_family_id = $family->id;
            $AFM->attribute_id = $value;
            $AFM->save();
        }


        return response()->json();
    }
}
