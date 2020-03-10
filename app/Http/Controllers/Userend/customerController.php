<?php

namespace App\Http\Controllers\Userend;

use App\Customer;
use App\Order;
use App\Temp_Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class customerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('customerAuth.home');
    }
    public function checkout($id)
    {
        $temp_orders = Temp_Order::find(Crypt::decrypt($id));
        $cart_datas = Cart::content();
        return view('pages.checkout',compact('cart_datas','temp_orders'));
    }

    public function myOrder($id)
    {
        $temp_Orders = Temp_Order::where('customer_id', Crypt::decrypt($id) )
                                 ->where('invoice_id','!=',null)
                                 ->get();
        $orders = Order::where('customer_id', Crypt::decrypt($id))->get();

        return view('pages.myOrder',compact('temp_Orders','orders'));
    }

    public function myProfile()
    {
        $customer = Customer::find( Auth::user()->id );
        return view( 'pages.myProfile',compact('customer') );
    }

    public function editMyProfile($id)
    {
        $customer = Customer::find(Crypt::decrypt($id));
        return view( 'pages.editMyProfile',compact('customer') );
    }

    public function profile_edit(Request $request)
    {
        $update = Customer::find($request->id);
        $image = $request->file('image');
        if(!empty($image))
        {
            $image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image->move('assets/vendor/images/profile_picture/',$image_name);


            $update->update([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $image_name,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'gender' => $request->gender,
            ]);
        }

        $update->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);


        return redirect()->route('pages.myProfile');
    }
}
