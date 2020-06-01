<?php

namespace App\Http\Controllers\Userend;

use App\Order;
use App\Payment;
use App\Shipping;
use Cart;
use App\Product;
use App\Temp_Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class orderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function myOrder($id)
    {
        $orders = Order::where('customer_id', Crypt::decrypt($id))
            ->where('payment_id','!=',null)
            ->orderBy('id', 'desc')
            ->paginate(5);
        return view('pages.myOrder',compact('orders'));
    }

    public function confirmedOrderDetails($id)
    {
        $oid = Crypt::decrypt($id);
        $order = Order::where('id',$oid)->first();
        $product_ids = json_decode($order->product_ids);

        //$products = Product::wherein('id',$product_ids)->orderBy('id','DESC')->get(); // error asc or desc
        $ids_ordered = implode(',', $product_ids);
        $products = Product::wherein('id',$product_ids)->orderByRaw("FIELD(id, $ids_ordered)")->get();
//      //
        $base_price = json_decode($order->base_price);
        $selling_price = json_decode($order->selling_price);
        $quantity = json_decode($order->quantity);
        $offer_type = json_decode($order->offer_type);
        $offer_percentage = json_decode($order->offer_percentage);
        $free_product_ids = json_decode($order->free_product_ids);
        $free_products = Product::wherein('id',$free_product_ids)->get();

        //print_r($free_product_ids);
        //echo $selling_price[0] + $selling_price[0] ;
        return view('pages.order_details',compact('order','products','base_price','selling_price','quantity','offer_type','offer_percentage','free_products'));
    }

    public function generateInvoice($id)
    {
        $oid = Crypt::decrypt($id);
        $order = Order::where('id',$oid)->first();
        $product_ids = json_decode($order->product_ids);

        //$products = Product::wherein('id',$product_ids)->orderBy('id','DESC')->get(); // error asc or desc
        $ids_ordered = implode(',', $product_ids);
        $products = Product::wherein('id',$product_ids)->orderByRaw("FIELD(id, $ids_ordered)")->get();
//      //
        $base_price = json_decode($order->base_price);
        $selling_price = json_decode($order->selling_price);
        $quantity = json_decode($order->quantity);
        $offer_type = json_decode($order->offer_type);
        $offer_percentage = json_decode($order->offer_percentage);
        $free_product_ids = json_decode($order->free_product_ids);
        $free_products = Product::wherein('id',$free_product_ids)->get();
        $pdf = PDF::loadView('pdf/pdf', compact('order','products','base_price','selling_price','quantity','offer_type','offer_percentage','free_products'));
        return $pdf->stream('order :'.$order->invoice_id.'.pdf');
    }
}
