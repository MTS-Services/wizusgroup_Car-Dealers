<?php

namespace App\Services\Admin\GroupShipping;

use App\Models\ContainerReservation;
use Illuminate\Database\Eloquent\Collection;

class ContainerReservationService
{
    public function getContainerReservations($orderby = 'sort_order', $order = 'asc')
    {
        return ContainerReservation::orderBy($orderby, $order)->latest();
    }

    public function getContainerReservation(string $param, $type = 'encryptedId'): ContainerReservation|Collection
    {
        return match ($type) {
            'encryptedId' => ContainerReservation::findOrFail(decrypt($param)),
            default => ContainerReservation::where($type, $param)->first(),
        };
    }
}
