<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class OrdersSheet implements FromArray, WithHeadings, WithTitle,  ShouldAutoSize, WithStyles
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function title(): string
    {
        return 'Orders Details';
    }

    public function headings(): array
    {
        return [
            "#",
            'Order ID',
            'Invoice Number',
            'Customer Name',
            'Customer Phone',
            'Customer Email',
            'Customer Address',
            'Type',
            'Order Items',
            'Sub Total Amount',
            'Discount Percentage',
            'Discount Amount',
            'Advance Amount',
            'Total Amount',
            'Balance Amount',
            'Order Status',
            'Payment Status',
            'Created At',
        ];
    }


    public function array(): array
    {
        return $this->orders->map(function($order, $index){
            return [
                $index + 1,
                $order->id,
                $order->invoice->invoice_number,
                $order->customer->name,
                $order->customer->phone,
                $order->customer->email,
                $order->customer->address,
                $order->type,
                $order->orderItems->count(),
                format_inr(number_format($order->invoice->sub_total_amount)),
                $order->invoice->discount_percentage,
                format_inr(number_format($order->invoice->discount_amount)),
                format_inr(number_format($order->invoice->advance_pay_amount)),
                format_inr(number_format( $order->invoice->total_amount)),
                format_inr(number_format( $order->invoice->balance_amount)),
                $order->status,
                $order->invoice->payment_status,
                $order->created_at->toDateTimeString(),
            ];
        })->toArray();
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'name'      =>  'Calibri',
                    'size'      =>  15,
                    'bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'EFEFEF'], 
                ],
            ],

        ];
    }
}
