<?php

namespace App\Http\Controllers;

// use App\RepositoryInterface\UserRepositoryInterface;
use Illuminate\Http\Request;
// use App\RepositoryInterface\UsersRepositoryInterface;

use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function index()
    {

        $users = DB::table('roles')
            ->join('users', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->paginate(10);
        return response()->json($users);
    }

    public function search(Request $request)
    {


        $users = User::where('users.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->paginate(10);
        return response()->json($users);
    }

    public function create()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function store(Request $request)
    {


        // dd($request->all());

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:30',
        //     'email' => 'required|email|unique:users',
        //     'phone' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 401);
        // }


        foreach ($request->post('count') as $value) {
         
            $user = new User();
            $user->name = $request['name'][$value];
            $user->phone = $request['phone'][$value];
            $user->email = $request['email'][$value];
            $user->password = bcrypt($request['password'][$value]);
            $user->address = $request['address'][$value];
            $user->role_id = $request['role'][$value];
            $user->status = $request['status'][$value];
            $user->save();
        }


        return back();
    }

    public function edit(Request $request)
    {
        $user = User::where('users.id', $request->id)
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->get();

        $role = Role::all();
        return response()->json(['user' => $user, 'role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request)
    // {
    //     $product = Product::find($request->id);
    //     $product->update($request->post());
    //     return response()->json($request);
    // }
}
