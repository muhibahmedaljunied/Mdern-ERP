<?php

namespace App\Repository\StoreInventury;

use App\Repository\StoreInventury\StoreRepository;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class OpeningRepository extends StoreRepository implements StoreRepositoryInterface
{



    public function __construct(CoreService $core)
    {
        $this->core = $core;
        $this->operation = 'increment';
    }
    public function store()
    {

        $this->get_store_product_tow();
        $this->check_founded_store();
    }


    public function check_founded_store()
    {


        if ($this->core->id_store_product == 0) {


            $this->init_store_product_table();
        } else {


            $this->refresh_store_product();
        }
    }

    public function refresh_store_product()
    {



        $this->refresh_qty_store_product_table();
        $this->refresh_total_store_product_table();
        $this->get_store_product_tow();
        $this->refresh_cost_store_product_table();
    }
}
