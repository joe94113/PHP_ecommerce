<?php

namespace App\Exports\sheets;

use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrderByShippedSheet implements FromCollection, WithHeadings, WithTitle
{
    public $isShipped;
    public function __construct($isShipped)
    {
        $this->isShipped = $isShipped;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::where('is_Shipped', $this->isShipped)->get();
    }

    public function headings(): array  // 回傳要是資料型態
    {
        return Schema::getColumnListing('orders');
    }

    public function title(): string
    {
        return $this->isShipped ? '已運送' : '尚未運送';
    }
}
