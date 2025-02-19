<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

    protected $fillable = [

        'name',

        'phone',

        'email',

        'salary',
        'register',
        'personal_card',

        'date',

        'staff_status',

        'social_status',

        'barth_date',

        'qualification_id',
        'gender',
        'branch_id',

        'department_id',

        'job_id',

        'staff_type_id',

        'religion_id',

        'nationality_id',
    ];



    public function work_system()
    {
        return $this->hasMany(WorkSystem::class);
    }

    public function period_time()
    {
        return $this->belongsToMany(PeriodTime::class, 'work_systems');
    }





    public function absence()
    {

        return $this->hasMany(Absence::class);
    }


    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }


    public function allowance()
    {
        return $this->hasMany(Allowance::class);
    }

    public function payroll()
    {
        return $this->hasMany(Payroll::class);
    }


    public function staff_allowance()
    {
        return $this->hasMany(StaffAllowance::class);
    }

    public function discount()
    {
        return $this->hasMany(Discount::class);
    }

    public function extra()
    {
        return $this->hasMany(Extra::class);
    }
    public function advance()
    {
        return $this->hasMany(Advance::class);
    }

    public function vacation()
    {
        return $this->hasMany(Vacation::class);
    }


    public function department()

    {

        return $this->belongsTo(AdministrativeStructure::class);
    }

    public function job()

    {

        return $this->belongsTo(AdministrativeStructure::class, 'job_id');
    }

    public function qualification()

    {

        return $this->belongsTo(Qualification::class);
    }


    public function branch()

    {

        return $this->belongsTo(Branch::class);
    }


    public function staff_type()

    {

        return $this->belongsTo(StaffType::class);
    }



    public function work_type()

    {

        return $this->belongsTo(WorkType::class);
    }





    public function staff_religion()

    {

        return $this->belongsTo(StaffReligion::class);
    }

    public function nationality()

    {

        return $this->belongsTo(Nationality::class);
    }

    public function staff_sanction()
    {
        return $this->hasMany(StaffSanction::class);
    }
}
