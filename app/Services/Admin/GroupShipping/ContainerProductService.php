<?php

namespace App\Services\Admin\GroupShipping;

use App\Models\ContainerProduct;

class ContainerProductService
{
  
        public function getContainerProducts($orderby = 'sort_order', $order = 'asc')
    {
        return ContainerProduct::orderBy($orderby, $order)->latest();
    }

    
}
