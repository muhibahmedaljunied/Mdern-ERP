<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use App\Models\AccountYear;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PeriodController extends Controller
{



    public function index()
    {



        $periods =  AccountYear::all();


        return response()->json([
            'account_years' => $periods
        ]);
    }




    // Create connection
    // $conn = new mysqli(
    //     Config::get("database.connections.mysql.host"),
    //     Config::get("database.connections.mysql.username"),
    //     Config::get("database.connections.mysql.password")
    // );
    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    // // Create database
    // $sql = "CREATE DATABASE " . $new_database;
    // if ($conn->query($sql) === TRUE) {
    //     echo "Database created successfully";
    // } else {
    //     echo "Error creating database: " . $conn->error;
    // }

    public function create_new_year($year)
    {

        // $new_database = env('DB_DATABASE') . $year;
        // $old_database = env('DB_DATABASE_second');
        // $path = base_path('.env');
        // $test = file_get_contents($path);

        // if (file_exists($path)) {
        //     file_put_contents($path, str_replace("DB_DATABASE_second=$old_database", "DB_DATABASE_second=$new_database", $test));
        // }

        // Config::set("database.connections.mysql2.database", env('DB_DATABASE_second', 'forge'));
        // DB::connection('mysql')->statement("CREATE DATABASE $new_database");



        // Refactored Version (No .env Editing) from co_pilot 


        // Step 1: Generate new database name
        $newDatabase = env('DB_DATABASE') . $year;

        // Step 2: Set it dynamically in Laravel's config
        Config::set('database.connections.mysql_dynamic.database', $newDatabase);

        // Step 3: Create the new database
        DB::connection('mysql')->statement("CREATE DATABASE `$newDatabase`");

        // Step 4 Laravel cache
        cache()->put('active_database', $newDatabase);

        // Then retrieve it later with:
        $active_database = cache('active_database');
        Config::set('database.connections.mysql_dynamic.database', $active_database);





        // ---------------------------------------------------------------------------------
    }

    public function init_new_year_data($data)
    {


        foreach ($data['data'] as $value) {

            $table = DB::select('select * from ' . $value);
            foreach ($table as $record) {
                DB::connection('mysql2')
                    ->table($value)
                    ->insert(get_object_vars($record));
            }
        }
    }

    public function close_period($data) {}






    public function create_account_year($request)
    {

        // dd($request);
        $account = new AccountYear();
        $account->name = $request['year'];
        $account->start_date = $request['start_date'];
        $account->end_date = $request['end_date'];
        $account->status = 0;
        $account->save();
    }




    // dd($request->all());

    // DB::connection('mysql')->statement("CREATE DATABASE yemen");

    // $tenantName = 'mysql_112';
    // $config = App::make('config');
    // $connections = $config->get('database.connections');

    // $defaultConnection = $connections[$config->get('database.default')];

    // // Now we simply copy the default connection information to our new connection.
    // $newConnection = $defaultConnection;

    // $newConnection['database'] = $tenantName;

    // // This will add our new connection to the run-time configuration for the duration of the request.



    // App::make('config')->set('database.connections.'.$tenantName,$newConnection);

    // -------------------------------------------------------------------------------
    // $runtimeConnectionConfig = config('database.connections.mysql');

    // config(['database.connections.mysql_120' => $runtimeConnectionConfig]);
    // Config::set('database.connections.mysql_120.database', 'warehousemuh');
    // $runtimeConnectionConfig = config('database.connections.mysql_120');
    // $data = $runtimeConnection->table('users')->get();


    // -----------------------


    // APP_ENV=local

    // $new_database = 'warehouse2025';
    // $old_database = 'warehouse';
    // DB::connection('mysql')->statement("CREATE DATABASE $new_database");

    // $path = base_path('.env');
    // $test = file_get_contents($path);

    // if (file_exists($path)) {
    //     file_put_contents($path, str_replace("DB_DATABASE=$old_database", "DB_DATABASE=$new_database", $test));
    // }


    // dd($test);

    // --------------------------------------------------------------------------------------------------------------------------
    // dd($request['data']);




    public function store_account_period(Request $request)
    {


        $this->open_new_period($request);
        $this->copy_data_into_new_period($request);


        return response()->json('Year Created successfully');
    }


    public function open_new_period($request)
    {


        if ($request['year']) {

            $this->create_new_year($request['year']);
        }
        $this->create_account_year($request);
    }


    public function copy_data_into_new_period($request)
    {


        Artisan::call("migrate --database=mysql2");
        $this->init_new_year_data($request);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

        $account = Account::find($id);
        return response()->json(['account' => $account]);
    }

    public function account_edit_node(Request $request, $id)
    {

        $data = Account::find($id);
        return response()->json(['data' => $data]);
    }

    public function destroy($id)
    {

        $product = Account::find($id);

        $product->delete();
    }
}
