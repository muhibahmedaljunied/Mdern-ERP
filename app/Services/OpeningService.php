<?php

namespace App\Services;


use Illuminate\Http\Request;
use App\Repository\StockInventury\StockRepository;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\RepositoryInterface\UnitRepositoryInterface;
use App\Services\DailyStockService;

class OpeningService
{

    public function __construct(

        public Request $request,
        public CoreService $core,
        // public DailyStockService $daily,
        public StoreRepositoryInterface $store,
        public DetailRepositoryInterface $detail,
        public StockRepository $stock,
        public UnitRepositoryInterface $unit,



    ) {



        $this->core->setData($this->request->all());
       
    }

    public function handle()
    {


        foreach ($this->core->data['count'] as $value) {

            $this->core->setValue($value);
            $this->handle_core();
        }
    
        // $this->daily->daily()->exicute('debit')->exicute('credit');



    }

    public function handle_core()
    {
      
        $this->unit->handle_unit();
        $this->store->store();
        $this->detail->details();
        $this->stock->stock();

    }

}
