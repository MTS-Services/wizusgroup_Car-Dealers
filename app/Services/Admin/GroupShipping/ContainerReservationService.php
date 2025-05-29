<?php

namespace App\Services\Admin\GroupShipping;

use App\Models\ContainerReservation;

class ContainerReservationService
{
        public function getContainerReservations($orderby = 'sort_order', $order = 'asc')
    {
        return ContainerReservation::orderBy($orderby, $order)->latest();
    }
}
