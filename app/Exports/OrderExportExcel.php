<?php

namespace App\Exports;

use App\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExportExcel implements FromView
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function view(): View
    {
        return view('vendor.order_management.excel_table', [
            'search_result' => Order::whereIn('id',$this->data)->orderBy('updated_at','DESC')->get() /*$this->data*/
        ]);
    }
}
