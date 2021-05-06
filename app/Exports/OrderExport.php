<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderExport implements FromCollection, WithHeadings, WithColumnFormatting, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $dataCount;

    public function collection()
    {
        $orders = Order::with(['user', 'cart.cartItems.product'])->get();
        $orders = $orders->map(function ($order) {
            return [
                $order->id,
                $order->user->name,
                $order->is_shipped,
                $order->cart->cartItems->sum(function ($cartItem) {
                    return $cartItem->product->price * $cartItem->quantity;
                }),
                Date::dateTimeToExcel($order->created_at)  // 改成excel時間格式
            ];
        });
        $this->dataCount = $orders->count();
        return $orders;
    }

    public function headings(): array  // 回傳要是資料型態
    {
        return ['編號', '購買者', '是否運送', '總價', '建立時間'];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(10);  // 設定A欄位寬度
                for ($i = 0; $i < $this->dataCount; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(30);  // 設定全部行，高度50
                }
                $event->sheet->getDelegate()->getStyle('A1:B' . $this->dataCount)->getAlignment()->setVertical('center');  // 設定置中
                $event->sheet->getDelegate()->getStyle('A1:A' . $this->dataCount + 1)->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'bold' => true,
                        'italic' => true,
                        'color' => [
                            'rgb' => 'FF0000'
                        ]
                    ],

                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '000000'
                        ],
                        'endColor' => [
                            'rgb' => '000000'
                        ],

                    ]
                ]);
                $event->sheet->getDelegate()->mergeCells('G1:H1');  // 合併儲存格
            }
        ];
    }
}
