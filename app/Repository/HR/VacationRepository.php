<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\Vacation;
class VacationRepository
{
    // public $core;

    public $staff_id;
    public $vacation_type_id;
    public $start_date;
    public $end_date;
    public $duration;








    public function __construct(public CoreStaffService $core)
    {

       

    }
    public function handle()
    {


        $this->update();
        $this->store();
    }
    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_vacation = 0;
            foreach ($sub->vacation as $key => $value) {

                $sub->sum_vacation += $value->total_days;
            }
        }
    }
    function store()
    {




        if ($this->core->temporale_f->isEmpty()) {

            $temporale = Vacation::updateOrCreate(
                [
                    'staff_id' => $this->staff_id,
                    'vacation_type_id' => $this->vacation_type_id,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'total_days' => $this->duration,


                ]
            );
            $this->core->id = $temporale->id;
        }
    }

    public function update()
    {




 
        $this->core->temporale_f  = tap(Vacation::whereLeave($this->core->data,$this->core->value))
            ->update(['total_days' => $this->core->data['days'][$this->core->value]])
            ->get('id');

      
    }
}
