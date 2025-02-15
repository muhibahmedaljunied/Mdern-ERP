<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Services\CoreService;
use App\Traits\OpeninngInventoryDetailsTrait;

class OpeninngInventoryDetailRepository implements DetailRepositoryInterface
{

use OpeninngInventoryDetailsTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }



    public function details(...$list_data)
    {

        $this->add_into_opening_inventory_details_table();
  
    }

   
 

   
}
