<?php

namespace App\Services;

use App\Models\FamilyAttributeOption;
use App\Models\ProductPrice;
use App\Models\StoreProduct;
use App\Repository\CheckData\CheckSaleReturnRepository;
use Illuminate\Http\Request;
use App\Repository\StockInventury\StockRepository;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\RepositoryInterface\UnitRepositoryInterface;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Services\DailyStockService;


class  StockService
{

    public function __construct(

        public Request $request,
        public CoreService $core,
        public StockesService $stockes,
        public DailyStockService $daily,
        public DetailRepositoryInterface $detail,
        public StoreRepositoryInterface $store,
        public StockRepository $stock,
        public UnitRepositoryInterface $unit,
        public WarehouseRepositoryInterface $warehouse,
        public PaymentService $payment,
        public CheckSaleReturnRepository $check,




    ) {



        $this->check =  $check;
        $this->core->setData($this->request->all());
        $this->core->setDiscount($this->request['discount'] * $this->request['grand_total'] / 100);
    }

    public function handle()
    {


        // dd($this->core->data);
        // $this->check_return_qty();
        $this->warehouse->add();
        // foreach ($this->core->data['count'] as $value) {
            // dd(ProductPrice::all());
        for ($value = 0; $value < $this->core->data['count']; $value++) {

            if ($this->core->data['total'][$value] > 0) {

                // dd($value);
                $this->core->setValue($value);
                $this->handle_core();

            }


        }

        // dd(ProductPrice::all());
        dd('finall');

        $this->payment->pay();



        // $this->daily->daily()->exicute('debit')->exicute('credit');

        // $this->warehouse->refresh(); //this update purchase_return table by daily_id


    }

    public function handle_core()
    {

        $this->unit->handle_unit();

        $this->store->store();

        $this->detail->details();

        $this->stock->stock();
    }

    public function check_return_qty()
    {

        foreach ($this->core->data['count'] as $value) {
            // for ($value = 0; $value < $this->core->data['count']; $value++) {

            $result = $this->check->check_return($value);

            if ($result['status'] == 0) {
                return response(['message' => $result['text'], 'status' => $result['status']]);
            }
        }
    }
}
