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
            'status' => "Pending"
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
//        return response()->json($updateNote);

    }

    public function defaulters()
    {
        $havetime_id = array();
        $orders = InstallmentOrder::all();
        foreach ($orders as $order){
            $installment_date = json_decode($order->installment_dates);
            $installment_status = json_decode($order->installment_status);
            foreach ($installment_date as $key => $install_date){
                $chosen_date = new Carbon($install_date);
                if( Carbon::today()->gt($chosen_date) && $installment_status[$key] === 'pending' ){
                    $havetime_id[] = $order->id;
                    break;
                }
                else{
                    $latePayments_id[] = $order->id;
                }
            }
        }

        $late_orders = InstallmentOrder::whereIn('id',$havetime_id)->get();

        return view('installment.defaulter_management.defaulters',compact('late_orders'));
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
        $date = $_GET['date'];
        $chosen_date = Carbon::parse($date);

        $order_id = array();
        $orders = InstallmentOrder::all();
        foreach ($orders as $order){
            $payment_dates = json_decode($order->payment_dates);
            foreach ($payment_dates as $payment_date){
                if(Carbon::parse($payment_date) == $chosen_date){
                    $order_id[] = $order->id;
                    break;
                }
            }
        }
        $per_date_orders = InstallmentOrder::whereIn('id',$order_id)->get();

        $returnHTML = view('installment.account_management.search_table_for_account')->with('per_date_orders', $per_date_orders)->with('selected_date',$chosen_date)->render();
        return response()->json(array( 'success'=>true, 'output' => $returnHTML, 'ids'=>$order_id ));
    }
}
