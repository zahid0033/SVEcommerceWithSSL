<?php

namespace App\Http\Controllers\Userend;

use App\Temp_Order;
use Cart;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index(){

        $previous_orders = Temp_Order::where ('customer_id',Auth::user()->id)
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

        $cart_datas = Cart::content();
//        dd($cart_datas);
        return view('pages.cart',compact('cart_datas'));
    }
    public function addItem($id){
        $pro = Product::find($id);

        $imgarray = json_decode($pro->image);

        if($pro->offer_id != null){

            if ($pro->offer_price != null){
                Cart::add(['id' => $pro->id,
                           'name' => $pro->name,
                           'qty' => 1,
                           'price' => $pro->offer_price,
                           'weight' => 1,
                           'options' => ['size' => $pro->size_capacity,
                                         'image'=>$imgarray[0]->image,
                                         'offer_type'=> "Discount",
                                         'offer_percentage'=> $pro->offers->offer_percentage ,
                                         'free_product'=> null,
                                         'free_product_id'=> null
                                         ]]);
            }
            else{
                $main_product_id = json_decode($pro->offers->product_ids);
                $free_product_id = json_decode($pro->offers->free_product_ids);
                for ($i=0; $i<count($main_product_id); $i++){
                    if($main_product_id[$i]->id == $pro->id){
                        $free_product = Product::find($free_product_id[0]->id);
                        Cart::add(['id' => $pro->id, 'name' => $pro->name, 'qty' => 1, 'price' => $pro->price, 'weight' => 1, 'options' => ['size' => $pro->size_capacity,'image'=>$imgarray[0]->image, 'offer_type'=> 'Buy one get one', 'offer_percentage'=> null , 'free_product'=>$free_product->name, 'free_product_id'=>$free_product_id[0]->id ]]);
                    }
                }
            }
        }
        else{
            Cart::add(['id' => $pro->id, 'name' => $pro->name, 'qty' => 1, 'price' => $pro->price, 'weight' => 1, 'options' => ['size' => $pro->size_capacity,'image'=>$imgarray[0]->image, 'offer_type'=> null, 'offer_percentage'=> null , 'free_product'=> null, 'free_product_id'=> null ]]);
        }

        return back();
    }
    public function deleteItem($rowId){
        Cart::remove($rowId);
        return back();
    }
    public function updateItem(Request $request){

        $qty = $request->qty;
        $rowId = $request->rowId;
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $product_name = $product->name;
        $stock =  $product->stock;
        $limit =  $product->offer_limit;

        if($product->offer_id != null){
            if ($qty > $limit){
                $request->validate([ 'qty' => 'required|numeric|min:1|max:'.$limit, ],
                    [
                        'qty.max' => 'Cant buy '.$product_name.' more than '.$limit.' at a time '
                    ]);
            }
            else{
                $request->validate([ 'qty' => 'required|numeric|min:1|max:'.$stock, ],
                    [
                        'qty.max' => 'Required quantity '.$qty.' for '.$product_name.' is not available in stock'
                    ]);
            }
        }
        else{
            $request->validate([ 'qty' => 'required|numeric|min:1|max:'.$stock, ],
                [
                    'qty.max' => 'Required quantity '.$qty.' for '.$product_name.' is not available in stock'
                ]);
        }



//        $request->validate([ 'qty' => 'required|numeric|min:1|max:'.$stock, ],
//            [
//                'qty.max' => 'Stock out of your limit'
//            ]);


        Cart::update($rowId, $qty);

        return redirect()->route('cart.index');
    }
}
