<?php

namespace App\Exports;

use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\sheets\OrderByShippedSheet;

class OrderMultipleExport implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function sheets(): array
    {
        $sheets =  [];
        foreach ([true, false] as $isShipped) {
            $sheets[] = new OrderByShippedSheet($isShipped);
        }

        return $sheets;
    }
}
