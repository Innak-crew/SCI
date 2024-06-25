<?php

namespace App\Exports;

use App\Models\Orders;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExport implements WithMultipleSheets
{
    use Exportable;

    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new DashboardSheet($this->orders);
        $sheets[] = new OrdersSheet($this->orders);

        foreach($this->orders as $order){
           
            $sheets[] = new OrderDetailsSheet($order);
        }

        return $sheets;
    }
}
