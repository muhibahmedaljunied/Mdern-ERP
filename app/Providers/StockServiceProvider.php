<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\StoreInventury\OpeningRepository;
use App\Repository\StoreInventury\StoreCashRepository;
use App\Repository\StoreInventury\StorePurchaseRepository;
use App\Repository\StoreInventury\StoreSaleRepository;
use App\Repository\StoreInventury\StoreSupplyRepository;
use App\Repository\StoreInventury\StoreCashReturnRepository;
use App\Repository\StoreInventury\StorePurchaseReturnRepository;
use App\Repository\StoreInventury\StoreSaleReturnRepository;
use App\Repository\StoreInventury\StoreSupplyReturnRepository;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class StockServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        $core = app(CoreService::class);
        $request = app(\Illuminate\Http\Request::class);

        $this->app->bind(StoreRepositoryInterface::class, function () use ($core, $request) {


            if ($request->type == 'Purchase') {
                return new StorePurchaseRepository($core);
            }
            if ($request->type == 'Sale') {
                return new StoreSaleRepository($core);
            }

            if ($request->type == 'Supply') {
                return new StoreSupplyRepository($core);
            }
            if ($request->type == 'Cash') {
                return new StoreCashRepository($core);
            }

            if ($request->type == 'PurchaseReturn') {
                return new StorePurchaseReturnRepository($core);
            }
            if ($request->type == 'SaleReturn') {

                return new StoreSaleReturnRepository($core);
            }

            if ($request->type == 'SupplyReturn') {
                return new StoreSupplyReturnRepository($core);
            }
            if ($request->type == 'CashReturn') {
                return new StoreCashReturnRepository($core);
            }

            if ($request->type == 'OpeningInventory') {

                return new OpeningRepository($core);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {}
}
