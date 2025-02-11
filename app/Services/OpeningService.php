<?php

namespace App\Services;


use Illuminate\Http\Request;
use App\Repository\StockInventury\StockRepository;
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
        public StockRepository $stock,
        public UnitRepositoryInterface $unit,



    ) {



        $this->core->setData($this->request->all());
        $this->core->setDiscount($this->request['discount'] * $this->request['grand_total'] / 100);
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

        $this->stock->stock();

    }

}
