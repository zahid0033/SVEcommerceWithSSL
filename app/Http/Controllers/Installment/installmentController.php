<?php

namespace App\Http\Controllers\Installment;

use App\InstallmentCustomer;
use App\InstallmentOrder;
use App\Order;
use App\Product;
use App\Temp_Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class installmentController extends Controller
{
    public function index()
    {
        return view('installment.dashboard.index');
    }

    public function products()
    {
        $products = Product::all();
        return view('installment.product_management.index',compact('products'));
    }

    public function makeOrder($id)
    {
        $customers = InstallmentCustomer::all();
        $product = Product::where('id',Crypt::decrypt($id))->first();
        return view('installment.order_management.makeOrder',compact('product','customers'));
    }

    public function placeOrder(Request $request)
    {
        $product_id = $request->product_id;
        $product_price = $request->product_price;
        $reduced_price = $request->reduced_price;
        $downPayment = $request->downPayment;
        $due_amount = $request->due_amount;
        $time_difference = $request->time_difference;
        $paid_amount = $request->paid_amount;
        $installment_number = $request->installment_number;
        $installment_amount = $request->installment_amount;
        $date = $request->date;
        $start_date = Carbon::parse($date);


        if($time_difference == 'weekly'){
            for ($i = 1; $i<= $installment_number; $i++){
                $installment_dates[] = $start_date->addWeek(1)->toFormattedDateString();
                $payment_dates[] = null;
                $installment_status[] = "pending";
                $installment_note[] = null;
            }
        }
        elseif($time_difference == 'monthly'){
            for ($i = 1; $i<= $installment_number; $i++){
                $installment_dates[] = $start_date->addMonth(1)->toFormattedDateString();
                $payment_dates[] = null;
                $installment_status[] = "pending";
                $installment_note[] = null;
            }
        }
        elseif($time_difference == 'yearly'){
            for ($i = 1; $i<= $installment_number; $i++){
                $installment_dates[] = $start_date->addYear(1)->toFormattedDateString();
                $payment_dates[] = null;
                $installment_status[] = "pending";
                $installment_note[] = null;
            }
        }

        InstallmentOrder::create([
            'product_id' => $product_id,
            'customer_id' => $request->customer_id,
            'product_price' => $product_price,
            'reduced_price' => $reduced_price,
            'downPayment' => $downPayment,
            'due_amount' => $due_amount,
            'paid_amount' => $paid_amount,
            'time_difference' => $time_difference,
            'installment_number' => $installment_number,
            'installment_amount' => $installment_amount,
            'installment_dates' => json_encode($installment_dates),
            'payment_dates' => json_encode($payment_dates),
            'installment_status' => json_encode($installment_status),
            'installment_note' => json_encode($installment_note),
            'status' => "Pending",
            'call_status' => "notCalled",
            'call_note' => "No Note Yet"
        ]);

        $find_product = Product::find($product_id);
        $find_product->update([
            'installment_stock' => $find_product->installment_stock - 1
        ]);

        return redirect()->route('installment.runningOrders');
    }

    public function searchCustomerForOrder()
    {
        $customer_id = $_GET['customer_id'];
        $customer = InstallmentCustomer::find($customer_id);
        $cus_name = $customer->name;
        $cus_email = $customer->email;
        $cus_phone = $customer->phone;
        $cus_address = $customer->address;

        return response()->json(array('success'=> true, 'cus_name'=>$cus_name, 'cus_email'=>$cus_email, 'cus_phone'=>$cus_phone, 'cus_address'=>$cus_address ));
    }

    public function previousOrders()
    {
        $previous_orders = InstallmentOrder::where('status','done')->get();
        return view('installment.order_management.previousOrder',compact('previous_orders'));
    }

    public function runningOrders()
    {
        $running_orders = InstallmentOrder::where('status','Pending')->get();
        return view('installment.order_management.runningOrder',compact('running_orders'));
    }

    public function updateOrder($id)
    {
        $orderId = Crypt::decrypt($id);
        $order = InstallmentOrder::find($orderId);
        return view('installment.order_management.updateOrder',compact('order'));
    }

    public function updateOrderStatus($orderId,$statusId,$status,$date)
    {
        $formatted_date = str_replace("-","/",$date);

        $order = InstallmentOrder::find($orderId);
        $installment_status = json_decode($order->installment_status);
        $payment_dates = json_decode($order->payment_dates);
        $installment_status[$statusId] = $status;
        $payment_dates[$statusId] = Carbon::parse($formatted_date)->toFormattedDateString();

        foreach ($installment_status as $key => $statusName){
            if ($statusName === "paid" || $statusName === "latePaid"){
                $statusCount[] = $statusName;
            }
        }

        $total = count($statusCount)*$order->installment_amount + $order->downPayment;
        $due_amount = $order->due_amount - $order->installment_amount;

        $updateOrderStatus = InstallmentOrder::find($orderId);

        if(in_array("pending", $installment_status)){
            $updateOrderStatus->update([
                'due_amount' => $due_amount,
                'paid_amount' => $total,
                'payment_dates' => json_encode($payment_dates),
                'installment_status' => json_encode($installment_status),
            ]);
        }else{
            $updateOrderStatus->update([
                'due_amount' => $due_amount,
                'paid_amount' => $total,
                'payment_dates' => json_encode($payment_dates),
                'installment_status' => json_encode($installment_status),
                'status' => 'done'
            ]);
        }

        return redirect()->back();
    }

    public function viewNoteDetails()
    {
        $order_id = $_GET['order_id'];
        $note_id = $_GET['note_id'];
        $order = InstallmentOrder::find($order_id);
        $installment_note = json_decode($order->installment_note);
        $installment_dates = json_decode($order->installment_dates);
        $note = $installment_note[$note_id];
        $date = $installment_dates[$note_id];
        return response()->json(array('success'=>true, 'note'=>$note, 'date'=>$date, 'note_id'=>$note_id));
    }

    public function updateNote(Request $request)
    {
        info('This is some useful information.');
        $main_order_id = $request->main_order_id;
        $note_id = $request->note_id;
        $prev_note = $request->prev_note;

        $updateNote = InstallmentOrder::find($main_order_id);
        $note = json_decode($updateNote->installment_note);
        $note[$note_id] = $prev_note;

        $updateNote->update([
            'installment_note' => json_encode($note),
        ]);

        return response()->json(array('success'=>true, 'postSubmit'=>"done" ));
    }

    public function defaulters()
    {
        $order_id = [];
        $nonDefaulterOrderId  = InstallmentOrder::where('id','>', 0)->pluck('id')->toArray();

        $orders = InstallmentOrder::all();
        foreach ($orders as $order){
            $installment_dates = json_decode($order->installment_dates);
            $installment_status = json_decode($order->installment_status);
            foreach ($installment_dates as $key => $installment_date){
                $chosen_date = new Carbon($installment_date);
                if( Carbon::today()->gt($chosen_date) && $installment_status[$key] === 'pending' ){
                    $order_id[] = $order->id;
                    break;
                }
            }
        }
        $result = array_diff($nonDefaulterOrderId,$order_id);

        InstallmentOrder::whereIn('id',$result)->update(['call_status'=> "notCalled",'call_note'=> "No Note Yet"]);

        return view('installment.defaulter_management.defaulters');
    }

    public function defaultersDateSearch(Request $request)
    {
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $dateRange = CarbonPeriod::create($start, $end);

        $dates = [];
        $order_id = [];

        foreach($dateRange as $date) {
            $dates[] = $date->toFormattedDateString();
        }

        $orders = InstallmentOrder::all();
        foreach ($orders as $order){
            $installment_dates = json_decode($order->installment_dates);
            $installment_status = json_decode($order->installment_status);
            foreach ($installment_dates as $key => $installment_date){
                $chosen_date = new Carbon($installment_date);
                if( Carbon::today()->gt($chosen_date) && $installment_status[$key] === 'pending' ){
                    if(in_array($installment_date, $dates)){
                        $order_id[] = $order->id;
                        break;
                    }
                }
            }
        }

        $late_orders = InstallmentOrder::whereIn('id',$order_id)->get();


        $returnHTML = view('installment.defaulter_management.search_table_for_defaulter')->with('late_orders', $late_orders)->render();
        return response()->json(array( 'success'=>true, 'output' => $returnHTML, 'ids'=>$order_id ));

    }

    public function viewDefaulterCallNote()
    {
        $order_id = $_GET['order_id'];
        $order = InstallmentOrder::find($order_id);
        $note = $order->call_note;
        $customer_name = $order->installmentCustomers->name;
        return response()->json(array('success'=>true,'note'=>$note,'customer_name'=>$customer_name));
    }

    public function updateDefaulterCallNote(Request $request)
    {
        $order_id = $request->main_order_id;
        $note = $request->note;

        $update = InstallmentOrder::find($order_id);
        $update->update([
           'call_note' => $note
        ]);
        return response()->json(array('success'=>true, 'postSubmit'=>"done" ));
    }

    public function updateDefaulterCallStatus($orderId,$status)
    {
        $order = InstallmentOrder::find($orderId);
        $order->update([
            'call_status' => $status
        ]);

        return redirect()->route('installment.defaulters');
    }

    public function customers()
    {
        $customers = InstallmentCustomer::all();
        return view('installment.customer_management.customerList',compact('customers'));
    }

    public function addCustomer()
    {
        return view('installment.customer_management.addCustomer');
    }

    public function createCustomer(Request $request)
    {
        InstallmentCustomer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('installment.addCustomer');
    }

    public function accounts()
    {
        return view('installment.account_management.accounts');
    }

    public function accountsPerDate()
    {
        $start = Carbon::parse($_GET['start_date']);
        $end = Carbon::parse($_GET['end_date']);
        $dateRange = CarbonPeriod::create($start, $end);

        $dates = [];
        $order_id = [];
        foreach($dateRange as $date) {
            $dates[] = $date->toFormattedDateString();
        }


        $orders = InstallmentOrder::all();
        foreach ($orders as $order){
            $payment_dates = json_decode($order->payment_dates);
            foreach ($payment_dates as $payment_date){
                if(in_array($payment_date, $dates)){
                    $order_id[] = $order->id;
                    break;
                }
            }
        }
        $per_date_orders = InstallmentOrder::whereIn('id',$order_id)->get();

        $returnHTML = view('installment.account_management.search_table_for_account')->with('per_date_orders', $per_date_orders)->with('selected_dates',$dates)->render();
        return response()->json(array( 'success'=>true, 'output' => $returnHTML, 'ids'=>$order_id ));
    }
}
