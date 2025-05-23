<?php

namespace App\Http\Controllers\Userend;

use App\Order;
use App\Payment;
use App\Product;
use App\Shipping;
use Cart;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Crypt;

class SslCommerzPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index(Request $request)
    {
        $request->validate([ 'checkbox' => 'accepted']);

        $user_id = $request->user_id;
        $cart_contents = Cart::content();

//        dd($cart_contents);

        # fetch carts data
        foreach ($cart_contents as $cart_content){

            $product_ids[] = $cart_content->id;
            $base_prices[] = $cart_content->options->base_price;
            $selling_prices[] = $cart_content->price;
            $quantities[] = $cart_content->qty;
            $offer_types[] = $cart_content->options->offer_type;
            $offer_percentages[] = $cart_content->options->offer_percentage;
            $free_product_ids[] = $cart_content->options->free_product_id;
        }
        $product_id = json_encode($product_ids);
        $base_price = json_encode($base_prices);
        $selling_price = json_encode($selling_prices);
        $quantity = json_encode($quantities);
        $offer_type = json_encode($offer_types);
        $offer_percentage = json_encode($offer_percentages);
        $free_product_id = json_encode($free_product_ids);

        # validation start
        for ($i=0; $i<count($cart_contents); $i++){
            $pro_id = Product::find($product_ids[$i]);
            $pro_stock = $pro_id->stock;
            $pro_limit = $pro_id->offer_limit;

            # if new stock is less than 0
            # then return to the cart page with proper validation error message
            $exact_product = Product::find($product_ids[$i]);
            $new_stock = $exact_product->stock - $quantities[$i];
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
            # if new stock is less than 0 (end)
            # normal validation if new stock is greater than 0 for inputs
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

            # normal validation if new stock is greater than 0 for inputs (end)
        }
        #  after perfect validation now reduce the product's stock based on cart
        for($i=0; $i<count($cart_contents); $i++){
            $update = Product::find($product_ids[$i]);
            $updated_stock = $update->stock - $quantities[$i];
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
            # after perfect validation now reduce the product's stock based on cart(end)
        }

        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = str_replace(',', '', Cart::total()); # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "NBO".mt_rand(10000000, 99999999); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_add1'] = Auth::user()->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = Auth::user()->city;
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = Auth::user()->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "YES";
        $post_data['ship_add1'] = $request->address;
        $post_data['ship_add2'] = "N/A";
        $post_data['ship_city'] = $request->city;
        $post_data['ship_state'] = "N/A";
        $post_data['ship_postcode'] = "N/A";
        $post_data['ship_phone'] = $request->phone;
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "N/A";
        $post_data['product_category'] = "N/A";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        # CART PARAMETERS
        for($i=0; $i<count($cart_contents); $i++){
            $cart_pro_id = Product::find($product_ids[$i]);
            $cart[] = array("product"=>$cart_pro_id->name,"quantity"=>$quantities[$i],"amount"=> $selling_prices[$i]);
        }
        $post_data['cart'] = json_encode($cart);
        $post_data['product_amount'] = str_replace(',', '', Cart::total());
        $post_data['vat'] = "0";
        $post_data['discount_amount'] = "0";
        $post_data['convenience_fee'] = "0";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        # shipping address start
        $shipping = Shipping::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
        ]);
        # shipping address end
        #   Order start
        $update_product = Order::create([
            'customer_id' => Auth::user()->id,
            'shipping_id' => $shipping->id,
            'invoice_id' => $post_data['tran_id'],
            'product_ids' => $product_id,
            'base_price' => $base_price,
            'selling_price' => $selling_price,
            'quantity' => $quantity,
            'offer_type' => $offer_type,
            'offer_percentage' => $offer_percentage,
            'free_product_ids' => $free_product_id,
            'status' => 'Pending',
        ]);
        #   Order end

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
//            print_r($payment_options);
            $payment_options = array();
            return redirect()->route('cart.index')->with('msg','✔ Try again');
        }

    }

    public function success(Request $request)
    {
//        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();
        #Check order status in order tabel against the transaction id or order id.
        $order_detials = Order::where('invoice_id',$tran_id)->first();

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
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

                $update_product = Order::where('invoice_id',$tran_id)->first();
                $update_product->update([
                    'payment_id' => $payment->id,
                    'status' => 'Processing'
                ]);

                Cart::destroy();
//                echo "<br >Transaction is successfully Completed";
                return redirect()->route('pages.myOrder',Crypt::encrypt(Auth::user()->id)  )->with('msg','✔ Transaction Successfull');
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
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

                $update_product = Order::where('invoice_id',$tran_id)->first();
                $update_product->update([
                    'payment_id' => $payment->id,
                    'status' => 'Failed'
                ]);

                Cart::destroy();
                return redirect()->route('pages.myOrder',Crypt::encrypt(Auth::user()->id)  )->with('msg','❎ Transaction Failed');
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed 2";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }


    }

    public function fail(Request $request)
    {
//        $tran_id = $request->input('tran_id');

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

        $order_detials = Order::where('invoice_id',$tran_id)->first();

        if ($order_detials->status == 'Pending') {
            $update_product = Order::where('invoice_id',$tran_id)->first();
            $update_product->update([
                'payment_id' => $payment->id,
                'status' => 'Failed'
            ]);

            $cart_contents = Cart::content();

            foreach ($cart_contents as $cart_content){
                $cart_ids[] = $cart_content->rowId;

                $product_ids[] = $cart_content->id;
                $quantities[] = $cart_content->qty;
            }

            # product quantity increase after transaction failed
            for ($i=0; $i<count($cart_contents); $i++){
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
            }
            # product quantity increase after transaction failed(end)

            Cart::destroy();
            return redirect()->route('pages.myOrder',Crypt::encrypt(Auth::user()->id)  )->with('msg','❎ Transaction Failed');

//            echo "Transaction is Falied";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = Order::where('invoice_id',$tran_id)->first();

        if ($order_detials->status == 'Pending') {

            Shipping::destroy($order_detials->shipping_id);
            Order::destroy($order_detials->id);

            $cart_contents = Cart::content();

            foreach ($cart_contents as $cart_content){
                $cart_ids[] = $cart_content->rowId;

                $product_ids[] = $cart_content->id;
                $quantities[] = $cart_content->qty;
            }

            for ($i=0; $i<count($cart_contents); $i++){
                # product quantity increase after transaction failed
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
                # product quantity increase after transaction failed (end)
            }
            return redirect()->route('cart.index')->with('msg','✔ You have cancelled the transaction');
//            echo "Transaction is Cancel";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = Order::where('invoice_id',$tran_id)->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
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

                    $update_product = Order::where('invoice_id',$tran_id)->first();
                    $update_product->update([
                        'payment_id' => $payment->id,
                        'status' => 'Processing'
                    ]);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
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

                    $update_product = Order::where('invoice_id',$tran_id)->first();
                    $update_product->update([
                        'payment_id' => $payment->id,
                        'status' => 'Failed'
                    ]);

                    # product amount increase after failure
                    $previous_order = Order::where('invoice_id',$tran_id)->first();


                    $cart_products = Order::find($previous_order->id);

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
                    # product amount increase after failure (end)

                    echo "validation Fail";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
