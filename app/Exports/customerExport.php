<?php

namespace App\Exports;

use App\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class customerExport implements FromView
{
    //protected $data;

    public function __construct(/*array $data*/)
    {
        //$this->data = $data;
    }
    public function view(): View
    {
        return view('vendor.customer_management.excel_table', [
            'search_result' => Customer::/*whereIn('id',$this->data)->*/orderBy('id','ASC')->get() /*$this->data*/
        ]);
    }
}
