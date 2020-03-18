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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class orderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }
    public function place_order(Request $request)
    {
        $user_id = $request->user_id;
        $cart_contents = Cart::content();

        foreach ($cart_contents as $cart_content){
            $cart_ids[] = $cart_content->rowId;
            $pro_ids[] = $cart_content->id;
            $quantity[] = $cart_content->qty;
        }

        for ($i=0; $i<count($cart_contents); $i++){
            $pro_id = Product::find($pro_ids[$i]);
            $pro_stock = $pro_id->stock;
            $pro_limit = $pro_id->offer_limit;

// if new stock is less than 0
            $product_id = $pro_ids[$i];
            $product_qty = $quantity[$i];
            $exact_product = Product::find($product_id);
            $new_stock = $exact_product->stock - $product_qty;
            if ($new_stock < 0){
                if($pro_id->offer_id != null){
                    if ($request->quantity[$i] > $pro_limit){
                        $request->validate(
                            [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_limit,],
                            [ 'quantity.'.$i.'.max' => 'Cant buy more than '.$pro_limit.' at a time '  ]);
                    }
                    elseif ($request->quantity[$i] <= $pro_limit){
                        $request->validate(
                            [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_stock,],
                            [ 'quantity.'.$i.'.max' => 'Required quantity '.$request->quantity[$i].' is not available in stock'  ]);
                    }
                }
                else{
                    $request->validate(
                        [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_stock,],
                        [ 'quantity.'.$i.'.max' => 'Required quantity '.$request->quantity[$i].' is not available in stock'  ]);
                }
            }
// if new stock is less than 0
            // normal validation for inputs
            if($pro_id->offer_id != null){
                if ($request->quantity[$i] > $pro_limit){
                    $request->validate(
                        [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_limit,],
                        [ 'quantity.'.$i.'.max' => 'Cant buy more than '.$pro_limit.' at a time '  ]);
                }
                elseif ($request->quantity[$i] <= $pro_limit){
                    $request->validate(
                        [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_stock,],
                        [ 'quantity.'.$i.'.max' => 'Required quantity '.$request->quantity[$i].' is not available in stock'  ]);
                }
            }
            else{
                $request->validate(
                    [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_stock,],
                    [ 'quantity.'.$i.'.max' => 'Required quantity '.$request->quantity[$i].' is not available in stock'  ]);
            }

            //normal validation for inputs
        }
        for($i=0; $i<count($cart_contents); $i++){
            //          testing###########################
            $product_id = $pro_ids[$i];
            $product_qty = $quantity[$i];
            $update = Product::find($product_id);
            $updated_stock = $update->stock - $product_qty;
            if($updated_stock == 0){
                $update->update([
                    'stock' => $updated_stock,
                    'status' => "Out of Stock",
                ]);

            }elseif ($updated_stock > 0){
                $update->update([
                    'stock' => $updated_stock,
                ]);
            }
//          testing##########################
        }

        return redirect()->route('temp_orders',$user_id);

    }
    public function temp_orders($user_id)
    {
        //        previous due payment order delete start
        $previous_orders = Temp_Order::where ('customer_id',$user_id)
            ->where('status','Due')
            ->get();

        if(!$previous_orders->isEmpty()){
            foreach($previous_orders as $previous_order){
                $cart_products = Temp_Order::find($previous_order->id);

                $cart_product = json_decode($cart_products->product_ids);
                $quantity = json_decode($cart_products->quantity);
                for($i = 0; $i < count($cart_product) ; $i++){
                    $pro_id = $cart_product[$i];
                    $quanty = $quantity[$i];
                    $updates = Product::find($pro_id);
                    $new_stock = $updates->stock + $quanty;
                    if($updates->stock == 0){
                        $updates->update([
                            'stock' => $new_stock,
                            'status' => "Available",
                        ]);
                    }elseif ($updates->stock > 0){
                        $updates->update([
                            'stock' => $new_stock,
                        ]);
                    }
                }
                Temp_Order::destroy($previous_order->id);
            }
        }
        //        previous due payment order delete end

        $cart_contents = Cart::content();


        foreach ($cart_contents as $cart_content){
            $product_id[] = $cart_content->id;
            $selling_prices[] = $cart_content->price;
            $quantities[] = $cart_content->qty;
            $offer_types[] = $cart_content->options->offer_type;
            $offer_percentages[] = $cart_content->options->offer_percentage;
            $free_product_id[] = $cart_content->options->free_product_id;

        }
        $product_ids = json_encode($product_id);
        $selling_price = json_encode($selling_prices);
        $quantity = json_encode($quantities);
        $offer_type = json_encode($offer_types);
        $offer_percentage = json_encode($offer_percentages);
        $free_product_ids = json_encode($free_product_id);


        $subtotal = str_replace(',', '', Cart::subtotal());
        $total = str_replace(',', '', Cart::total());


        $temp_order = Temp_Order::create([
            'customer_id' => Auth::user()->id,
            'shipping_id' => null,
            'vendor_id' => null,
            'invoice_id' => null,
            'product_ids' => $product_ids,
            'selling_price' => $selling_price,
            'quantity' => $quantity,
            'offer_type' => $offer_type,
            'offer_percentage' => $offer_percentage,
            'free_product_ids' => $free_product_ids,
            'status' => 'Due',
            'subtotal' => $subtotal,
            'total' => $total

        ]);



//        $cart_products = Temp_Order::find($temp_order->id);
//
//        $cart_product = json_decode($cart_products->product_ids);
//        for($i = 0; $i < count($cart_product) ; $i++){
//            $pro_id = $cart_product[$i];
//            $qty = $quantities[$i];
//            $update = Product::find($pro_id);
//            $new_stock = $update->stock - $qty;
//            if($new_stock == 0){
//                $update->update([
//                    'stock' => $new_stock,
//                    'status' => "Out of Stock",
//                ]);
//            }elseif ($new_stock > 0){
//                $update->update([
//                    'stock' => $new_stock,
//                ]);
//            }
//        }


//        Cart::destroy();
//        return view('pages.checkout',compact('temp_order'));
        return redirect()->route('pages.checkout', Crypt::encrypt($temp_order->id) );

//        dd($product_ids,$selling_price,$quantity,$offer_type,$offer_percentage,$free_product_ids,$subtotal,$total,$invoice_id);
    }
    public function paymentConfirm(Request $request)
    {
        $shipping = Shipping::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
        ]);

        $payment = Payment::create([
            'method' => "Manual",
            'trx_id' => $request->trx_number,
            'sender_mobile_number' => $request->sender_mbl,
            'status' => "Paid",
        ]);

        $update = Temp_Order::find($request->temp_order_id);
        $invoice_id = "NB".uniqid();
        $update->update([
            'shipping_id' => $shipping->id,
            'payment_id' => $payment->id,
            'invoice_id' => $invoice_id,
            'trx_id' => $request->trx_number,
            'sender_mobile_number' => $request->sender_mbl,
            'status' => "Pending",
        ]);

        $order = Temp_Order::find($request->temp_order_id);
//        ###########################   sslcommerz   ###############################################
        /* PHP */
        $post_data = array();
        $post_data['store_id'] = "dream5e5107ec2fcc2";
        $post_data['store_passwd'] = "dream5e5107ec2fcc2@ssl";
        $post_data['total_amount'] = $order->total;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "SSLCZ_TEST_".uniqid();
        $post_data['success_url'] =  "http://127.0.0.1:3000/successfulTransaction";
        $post_data['fail_url'] = "http://127.0.0.1:3000/failedTransaction";
        $post_data['cancel_url'] = "http://127.0.0.1:3000/cancelTransaction";
# $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

# EMI INFO
        $post_data['emi_option'] = "1";
        $post_data['emi_max_inst_option'] = "9";
        $post_data['emi_selected_inst'] = "9";

# CUSTOMER INFORMATION
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_add1'] = "Dhaka";
        $post_data['cus_add2'] = "Dhaka";
        $post_data['cus_city'] = "Dhaka";
        $post_data['cus_state'] = "Dhaka";
        $post_data['cus_postcode'] = "1000";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = "01711111111";
        $post_data['cus_fax'] = "01711111111";

# SHIPMENT INFORMATION
        $post_data['ship_name'] = "testdream33d8";
        $post_data['ship_add1 '] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_country'] = "Bangladesh";

# OPTIONAL PARAMETERS
        $post_data['value_a'] = $invoice_id;
        $post_data['value_b '] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

# CART PARAMETERS
        $post_data['cart'] = json_encode(array(
            array("product"=>"DHK TO BRS AC A1","amount"=>"200.00"),
            array("product"=>"DHK TO BRS AC A2","amount"=>"200.00"),
            array("product"=>"DHK TO BRS AC A3","amount"=>"200.00"),
            array("product"=>"DHK TO BRS AC A4","amount"=>"200.00")
        ));
        $post_data['product_amount'] = "100";
        $post_data['vat'] = "5";
        $post_data['discount_amount'] = "5";
        $post_data['convenience_fee'] = "3";


//       ############################# ##
        # REQUEST SEND TO SSLCOMMERZ
        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url );
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1 );
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


        $content = curl_exec($handle );

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if($code == 200 && !( curl_errno($handle))) {
            curl_close( $handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close( $handle);
            echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
            exit;
        }

# PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true );

        if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
            echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
            # header("Location: ". $sslcz['GatewayPageURL']);
            exit;
        } else {
            echo "JSON Data parsing errorsssss!";
        }

//        ###########################   sslcommerz   ###############################################


//        $order_id = $request->temp_order_id;
//        Return redirect()->route('paymentSuccess',['$order_id']);


    }
    public function paymentSuccess($id)
    {
        $temp_order = Temp_Order::find($id);
        return view('pages.successful',compact('temp_order'));

    }

    public function pendingOrderDetails($id)
    {
        $oid = Crypt::decrypt($id);
        $order = Temp_Order::where('id',$oid)->first();
        $product_ids = json_decode($order->product_ids);
        $products = Product::wherein('id',$product_ids)->get();
        $selling_price = json_decode($order->selling_price);
        $quantity = json_decode($order->quantity);
        $offer_type = json_decode($order->offer_type);
        $offer_percentage = json_decode($order->offer_percentage);
        $free_product_ids = json_decode($order->free_product_ids);
        $free_products = Product::wherein('id',$free_product_ids)->get();

        //print_r($free_product_ids);
        //echo $selling_price[0] + $selling_price[0] ;
        return view('pages.order_details',compact('order','products','selling_price','quantity','offer_type','offer_percentage','free_products'));
    }

    public function confirmedOrderDetails($id)
    {
        $oid = Crypt::decrypt($id);
        $order = Order::where('id',$oid)->first();
        $product_ids = json_decode($order->product_ids);
        $products = Product::wherein('id',$product_ids)->get();
        $selling_price = json_decode($order->selling_price);
        $quantity = json_decode($order->quantity);
        $offer_type = json_decode($order->offer_type);
        $offer_percentage = json_decode($order->offer_percentage);
        $free_product_ids = json_decode($order->free_product_ids);
        $free_products = Product::wherein('id',$free_product_ids)->get();

        //print_r($free_product_ids);
        //echo $selling_price[0] + $selling_price[0] ;
        return view('pages.order_details',compact('order','products','selling_price','quantity','offer_type','offer_percentage','free_products'));
    }

    public function successfulTransaction(Request $request)
    {
        $status = $request->status;
        $tran_id = $request->tran_id;
        $amount = $request->amount;
        $store_amount = $request->store_amount;
        $bank_tran_id = $request->bank_tran_id;
        $tran_date = $request->tran_date;
        $currency = $request->currency;
        $currency_type = $request->currency_type;
        $currency_amount = $request->currency_amount;
        $currency_rate = $request->currency_rate;
        $base_fair = $request->base_fair;
        $card_type = $request->card_type;
        $card_no = $request->card_no;
        $card_issuer = $request->card_issuer;
        $card_brand = $request->card_brand;
        $card_issuer_country = $request->card_issuer_country;
        $card_issuer_country_code = $request->card_issuer_country_code;

        $payment = Payment::create([
            'status' => $status,
            'invoice_id' => $tran_id,
            'amount' => $amount,
            'store_amount' => $store_amount,
            'bank_tran_id' => $bank_tran_id,
            'tran_date' => $tran_date,
            'currency' => $currency,
            'currency_type' => $currency_type,
            'currency_amount' => $currency_amount,
            'currency_rate' => $currency_rate,
            'base_fair' => $base_fair,
            'card_type' => $card_type,
            'card_no' => $card_no,
            'card_issuer' => $card_issuer,
            'card_brand' => $card_brand,
            'card_issuer_country' => $card_issuer_country,
            'card_issuer_country_code' => $card_issuer_country_code,
        ]);

        $order = Order::where('invoice_id',$tran_id)->first();
        $order->update([
            'payment_id' => $payment->id,
            'status' => 'Processing'
        ]);


        Cart::destroy();

/*        return view('pages.successfulTransaction',compact('status','tran_id','value_a','bank_tran_id','store_amount','val_id','amount','card_type','tran_date'));*/
    }

    public function failedTransaction(Request $request)
    {
//        dd($request,$request->value_a,$request->errorReason);
        $status = $request->status;
        $tran_id = $request->tran_id;
        $amount = $request->amount;
        $bank_tran_id = $request->bank_tran_id;
        $tran_date = $request->tran_date;
        $currency = $request->currency;
        $currency_type = $request->currency_type;
        $currency_amount = $request->currency_amount;
        $currency_rate = $request->currency_rate;
        $base_fair = $request->base_fair;
        $card_type = $request->card_type;
        $card_no = $request->card_no;
        $card_issuer = $request->card_issuer;
        $card_brand = $request->card_brand;
        $card_issuer_country = $request->card_issuer_country;
        $card_issuer_country_code = $request->card_issuer_country_code;
        $error = $request->error;

        $payment = Payment::create([
            'status' => $status,
            'invoice_id' => $tran_id,
            'amount' => $amount,
            'bank_tran_id' => $bank_tran_id,
            'tran_date' => $tran_date,
            'currency' => $currency,
            'currency_type' => $currency_type,
            'currency_amount' => $currency_amount,
            'currency_rate' => $currency_rate,
            'base_fair' => $base_fair,
            'card_type' => $card_type,
            'card_no' => $card_no,
            'card_issuer' => $card_issuer,
            'card_brand' => $card_brand,
            'card_issuer_country' => $card_issuer_country,
            'card_issuer_country_code' => $card_issuer_country_code,
            'error' => $error,
        ]);


        $order = Order::where('invoice_id',$tran_id)->first();
        $order->update([
            'payment_id' => $payment->id,
            'status' => 'Failed'
        ]);


        $cart_contents = Cart::content();

        foreach ($cart_contents as $cart_content){
            $cart_ids[] = $cart_content->rowId;

            $product_ids[] = $cart_content->id;
            $quantities[] = $cart_content->qty;
        }

        for ($i=0; $i<count($cart_contents); $i++){
            // testing product quantity  update ###########################
            $product_id = $product_ids[$i];
            $product_qty = $quantities[$i];
            $update = Product::find($product_id);
            $new_stock = $update->stock + $product_qty;
            if($new_stock == 0){
                $update->update([
                    'stock' => $new_stock,
                    'status' => "Available",
                ]);
            }elseif ($new_stock > 0){
                $update->update([
                    'stock' => $new_stock,
                ]);
            }
            // Testing product quantity update##########################

        }

        Cart::destroy();


/*        return view('pages.failedTransaction',compact('status','tran_id','error','value_a','bank_tran_id','store_amount','val_id','amount','card_type','tran_date'));*/

    }

    public function cancelTransaction(Request $request)
    {
        $tran_id = $request->tran_id;
        $error = $request->error;
        $status = $request->status;
        $bank_tran_id = $request->bank_tran_id;
        $value_a = $request->value_a;
        $tran_date = $request->tran_date;
        $amount = $request->amount;

        $order = Order::where('invoice_id',$tran_id)->first();
        Shipping::destroy($order->shipping_id);
        Order::destroy($order->id);

        $cart_contents = Cart::content();

        foreach ($cart_contents as $cart_content){
            $cart_ids[] = $cart_content->rowId;

            $product_ids[] = $cart_content->id;
            $quantities[] = $cart_content->qty;
        }

        for ($i=0; $i<count($cart_contents); $i++){
            // testing product quantity  update ###########################
            $product_id = $product_ids[$i];
            $product_qty = $quantities[$i];
            $update = Product::find($product_id);
            $new_stock = $update->stock + $product_qty;
            if($update->stock == 0){
                $update->update([
                    'stock' => $new_stock,
                    'status' => "Available",
                ]);
            }elseif ($update->stock > 0){
                $update->update([
                    'stock' => $new_stock,
                ]);
            }
            // Testing product quantity update##########################

        }

/*        return view('pages.cancelTransaction',compact('status','tran_id','error','value_a','bank_tran_id','store_amount','val_id','amount','card_type','tran_date'));*/

    }

    public function goPayment(Request $request)
    {
        // take cart contents in an array
        // json encode
        // product stock reduce
        // validation
        $user_id = $request->user_id;
        $cart_contents = Cart::content();

        foreach ($cart_contents as $cart_content){
            $product_ids[] = $cart_content->id;
            $selling_prices[] = $cart_content->price;
            $quantities[] = $cart_content->qty;
            $offer_types[] = $cart_content->options->offer_type;
            $offer_percentages[] = $cart_content->options->offer_percentage;
            $free_product_ids[] = $cart_content->options->free_product_id;

        }
        $product_id = json_encode($product_ids);
        $selling_price = json_encode($selling_prices);
        $quantity = json_encode($quantities);
        $offer_type = json_encode($offer_types);
        $offer_percentage = json_encode($offer_percentages);
        $free_product_id = json_encode($free_product_ids);


        for ($i=0; $i<count($cart_contents); $i++){
            $pro_id = Product::find($product_ids[$i]);
            $pro_stock = $pro_id->stock;
            $pro_limit = $pro_id->offer_limit;

//          decrease product quantity   ###########################
            $product_qty = $quantities[$i];
            $update = Product::find($product_ids[$i]);
            $new_stock = $update->stock - $product_qty;
            if($new_stock == 0){
                $update->update([
                    'stock' => $new_stock,
                    'status' => "Out of Stock",
                ]);

            }elseif ($new_stock > 0){
                $update->update([
                    'stock' => $new_stock,
                ]);

            }
//         decrease product quantity  ##########################

            if($pro_id->offer_id != null){
                if ($request->quantity[$i] > $pro_limit){
                    $request->validate(
                        [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_limit,],
                        [ 'quantity.'.$i.'.max' => 'Cant buy more than '.$pro_limit.' at a time '  ]);
                }
                elseif ($request->quantity[$i] <= $pro_limit){
                    $request->validate(
                        [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_stock,],
                        [ 'quantity.'.$i.'.max' => 'Required quantity '.$request->quantity[$i].' is not available in stock'  ]);
                }
            }
            else{
                $request->validate(
                    [ 'quantity.'.$i => 'required|numeric|min:1|max:'.$pro_stock,],
                    [ 'quantity.'.$i.'.max' => 'Required quantity '.$request->quantity[$i].' is not available in stock'  ]);
            }

        }



//        ###########################   sslcommerz   ###############################################
        /* PHP */
        $post_data = array();
        $post_data['store_id'] = "dream5e5107ec2fcc2";
        $post_data['store_passwd'] = "dream5e5107ec2fcc2@ssl";
        $post_data['total_amount'] = str_replace(',', '', Cart::total());
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "NBO_".uniqid();
        $post_data['success_url'] =  "http://127.0.0.1:3000/successfulTransaction";
        $post_data['fail_url'] = "http://127.0.0.1:3000/failedTransaction";
        $post_data['cancel_url'] = "http://127.0.0.1:3000/cancelTransaction";
# $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

# EMI INFO
        $post_data['emi_option'] = "1";
        $post_data['emi_max_inst_option'] = "9";
        $post_data['emi_selected_inst'] = "9";

# CUSTOMER INFORMATION
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_add1'] = "Dhaka";
        $post_data['cus_add2'] = "Dhaka";
        $post_data['cus_city'] = "Dhaka";
        $post_data['cus_state'] = "Dhaka";
        $post_data['cus_postcode'] = "1000";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = "01711111111";
        $post_data['cus_fax'] = "01711111111";

# SHIPMENT INFORMATION
        $post_data['ship_name'] = "testdream33d8";
        $post_data['ship_add1 '] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_country'] = "Bangladesh";

# OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b '] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

# CART PARAMETERS
        $post_data['cart'] = json_encode(array(
            array("product"=>"DHK TO BRS AC A1","amount"=>"200.00"),
            array("product"=>"DHK TO BRS AC A2","amount"=>"200.00"),
            array("product"=>"DHK TO BRS AC A3","amount"=>"200.00"),
            array("product"=>"DHK TO BRS AC A4","amount"=>"200.00")
        ));
        $post_data['product_amount'] = "100";
        $post_data['vat'] = "0";
        $post_data['discount_amount'] = "5";
        $post_data['convenience_fee'] = "3";

//      ############### shipping address start ############
        $shipping = Shipping::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
        ]);
//      ################ shipping address end ###########
//      ################ Order start ###########
        $order = Order::create([
            'customer_id' => Auth::user()->id,
            'shipping_id' => $shipping->id,
            'invoice_id' => $post_data['tran_id'],
            'product_ids' => $product_id,
            'selling_price' => $selling_price,
            'quantity' => $quantity,
            'offer_type' => $offer_type,
            'offer_percentage' => $offer_percentage,
            'free_product_ids' => $free_product_id,
            'status' => 'Pending',
        ]);
//      ################ Order end #########################


//       ############################# ##
        # REQUEST SEND TO SSLCOMMERZ
        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url );
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1 );
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


        $content = curl_exec($handle );

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if($code == 200 && !( curl_errno($handle))) {
            curl_close( $handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close( $handle);
            echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
            exit;
        }

# PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true );

        if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
            echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
            # header("Location: ". $sslcz['GatewayPageURL']);
            exit;
        } else {
            echo "JSON Data parsing errors!";
        }

//        ###########################   sslcommerz   ###############################################


    }
}
