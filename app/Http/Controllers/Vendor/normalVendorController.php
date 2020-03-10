<?php

namespace App\Http\Controllers\Vendor;

use App\Brand;
use App\Category;
use App\Customer;
use App\Contact;
use App\Offer;
use App\Payment;
use App\Product;
use App\Shipping;
use App\Temp_Order;
use App\Order;
use App\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade as PDF;

class normalVendorController extends Controller
{
    public function index()
    {
        $temp_due = Temp_Order::where('status','Due')->count();
        $temp_cancel = Temp_Order::where('status','Cancel')->count();
        $temp_pending = Temp_Order::where('status','Pending')->count();

        $order_processing = Order::where('status','Processing')->count();
        $order_shipping = Order::where('status','Shipping')->count();
        $order_delivered = Order::where('status','Delivered')->count();
        return view('vendor.dashboard.index',compact('temp_due','temp_cancel','temp_pending','order_processing','order_shipping','order_delivered'));
    }
//************************ page = category_management
    public function categoryManagementView()
    {
        $categories = Category::whereNull('parent_id')->paginate(8);
        $sub_categories = Category::whereNotNull('parent_id')->get();
        $sub = [];
        foreach ($sub_categories as  $value)
        {
            $sub[] = $value->parent_id;
        }
        $parent_id = NULL;
        return view('vendor.category_management.index',compact('categories','parent_id','sub'));
    }

    public function categoryAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $image = $request->file('image');
        if(!empty($image))
        {
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('assets/vendor/images/categories/',$image_name);
            if($request->parent_id == "undefined")
            {
                Category::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status,
                    'image' => $image_name,
                ]);
            }
            else
            {
                Category::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status,
                    'image' => $image_name,
                    'parent_id' => $request->parent_id,
                ]);
            }
        }
        else
        {
            if($request->parent_id == "undefined")
            {
                Category::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status,
                ]);
            }
            else
            {
                Category::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status,
                    'parent_id' => $request->parent_id,
                ]);
            }
        }

        return back()->with('msg','✔ Category Added');
    }
    public function categoryRemove($id)
    {
        $delete = Category::find($id);
        $delete->delete();
        if(!empty($delete->image)){unlink('assets/vendor/images/categories/'.$delete->image);}
        return redirect()->back()->with('msg',"✔ REMOVED");
    }

    public function subCategoryView($pid)
    {
        $categories = Category::where('parent_id',$pid)->paginate(10);
        $parent_id = $pid;
        $products = Product::whereNotNull('category_id')->get();
        $sub = [];
        foreach ($products as  $value)
        {
            $sub[] = $value->category_id;
        }
        return view('vendor.category_management.index',compact('categories','parent_id','sub'));
    }
    public function categoryUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $image = $request->file('image');
        $update = Category::find($request->id);
        if(!empty($image))
        {
            if(!empty($update->image))
            {
                unlink('assets/vendor/images/categories/'.$update->image);
            }
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('assets/vendor/images/categories/',$image_name);
            $update->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'image' => $image_name,
            ]);
        }
        else
        {
            $update->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);
        }
        return back()->with('msg','✔ Category Updated');
    }

    // ************************ page = category_management #

    // ************************ page = brand_management
    public function brandManagementView()
    {
        $brands = Brand::where('vendor_id',Auth::user()->id)->paginate(6);
        return view('vendor.brand_management.index',compact('brands'));
    }
    public function brandAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'description' => 'required|max:200',
            'address' => 'required|max:200',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $image = $request->file('image');
        if(!empty($image))
        {
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('assets/vendor/images/brands/',$image_name);

            Brand::create([
                'vendor_id' => Auth::user()->id,
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'description' => $request->description,
                'status' => /*$request->status*/'Active',
                'image' => $image_name,
            ]);
        }
        else
        {
            Brand::create([
                'vendor_id' => Auth::user()->id,
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'description' => $request->description,
                'status' =>  /*$request->status*/'Active',
            ]);
        }

        return back()->with('msg','✔ Brand Added');
    }
    public function brandManagementEdit($id)
    {
        $bid = Crypt::decrypt($id);
        $brand = Brand::where('id',$bid)->first();
        return view('vendor.brand_management.edit',compact('brand'));
    }
    public function brandUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
            'email' => 'required',
            'phone' => 'required',
            'description' => 'required|max:200',
            'address' => 'required|max:200',
        ]);
        $image = $request->file('image');
        $update = Brand::find($request->id);
        if(!empty($image))
        {

            unlink('assets/vendor/images/brands/'.$update->image);

            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('assets/vendor/images/brands/',$image_name);
            $update->update([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'description' => $request->description,
                /*'status' => $request->status,*/
                'image' => $image_name,
            ]);


        }
        else
        {
            $update->update([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'description' => $request->description,
                /* 'status' => $request->status,*/
            ]);


        }
        return back()->with('msg','✔ Brand Updated');
    }
    public function brandRemove($id)
    {
        $bid = Crypt::decrypt($id);
        $delete = Brand::find($bid);
        if(!empty($delete->image)){unlink('assets/vendor/images/brands/'.$delete->image);}
        $delete->delete();
        return redirect()->back()->with('msg',"✔ REMOVED");
    }
    //************************ page = brand_management #
    //************************ page = product_management
    public function productManagementView()
    {
        $brands = Brand::where('vendor_id',Auth::user()->id)->get();
        $products = Product::where('vendor_id',Auth::user()->id)->paginate(8);
        $categories = Category::where('status','Active')->get();

        return view('vendor.product_management.index',compact('brands','categories','products'));
    }
    public function productAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price' => 'required',
            'status' => 'required',
            'description' => 'required|max:10000',
            'specification' => 'max:100000',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);


        $image = $request->file('image');
        if(!empty($image))
        {
            foreach ($image as $files)
            {
                $image_name = uniqid().'.'.$files->getClientOriginalExtension();
                $files->move('assets/vendor/images/products/',$image_name);
                $insert[]['image'] = "$image_name";
            }
            $imageEncode = json_encode($insert);


            Product::create([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'vendor_id' => Auth::user()->id,
                'name' => $request->name,
                'specification' => $request->specification,
                'description' => $request->description,
                'stock' => $request->stock,
                'image' => $imageEncode,
                'price' => $request->price,
                'offer_price' => $request->offer_price,
                'offer_percentage' => $request->offer_percentage,
                'size_capacity' => $request->size_capacity,
                'model' => $request->model,
                'offer_limit' => $request->offer_limit,
                'color' => $request->color,
                'status' => $request->status,

            ]);
        }
        else
        {
            Product::create([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'vendor_id' => Auth::user()->id,
                'name' => $request->name,
                'specification' => $request->specification,
                'description' => $request->description,
                'stock' => $request->stock,
                /* 'image' => $request->image,*/
                'price' => $request->price,
                'offer_price' => $request->offer_price,
                'offer_percentage' => $request->offer_percentage,
                'size_capacity' => $request->size_capacity,
                'model' => $request->model,
                'offer_limit' => $request->offer_limit,
                'color' => $request->color,
                'status' => $request->status,
                /* 'slug' => $request->slug,*/
            ]);
        }

        return back()->with('msg','✔ Product Added');
    }
    public function productManagementEdit($id)
    {
        $pid = Crypt::decrypt($id);
        $product = Product::where('id',$pid)->first();
        $imgarray = json_decode($product->image);
        $brands = Brand::where('vendor_id',Auth::user()->id)->get();
        $categories = Category::where('status','Active')->get();
        return view('vendor.product_management.edit',compact('product','imgarray','brands','categories'));
    }
    public function productUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price' => 'required',
            'status' => 'required',
            'description' => 'required|max:10000',
            'specification' => 'max:100000',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $image = $request->file('image');
        $update = Product::find($request->id);

        if(!empty($image))
        {
            $imgarray = json_decode($update->image);
            foreach ($imgarray as $s)
            {
                unlink('assets/vendor/images/products/'.$s->image);
            }
            foreach ($image as $files)
            {

                $image_name = uniqid().'.'.$files->getClientOriginalExtension();
                $files->move('assets/vendor/images/products/',$image_name);
                $insert[]['image'] = "$image_name";
            }
            $imageEncode = json_encode($insert);

            $update->update([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'specification' => $request->specification,
                'description' => $request->description,
                'stock' => $request->stock,
                'image' => $imageEncode,
                'price' => $request->price,
                'offer_price' => $request->offer_price,
                'offer_percentage' => $request->offer_percentage,
                'size_capacity' => $request->size_capacity,
                'model' => $request->model,
                'offer_limit' => $request->offer_limit,
                'color' => $request->color,
                'status' => $request->status,
            ]);
        }
        else
        {
            $update->update([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'specification' => $request->specification,
                'description' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price,
                'offer_price' => $request->offer_price,
                'offer_percentage' => $request->offer_percentage,
                'size_capacity' => $request->size_capacity,
                'model' => $request->model,
                'offer_limit' => $request->offer_limit,
                'color' => $request->color,
                'status' => $request->status,
            ]);
        }
        return back()->with('msg','✔ Product Updated');
    }
    //************************ page = product_management #
    //************************ page = offer_management
    public function offerManagementView()
    {
        $products = Product::where('vendor_id',Auth::user()->id)->whereNull('offer_id')->where('status','!=','Disable')->orderBy('category_id','ASC')->get();
        $allProducts = Product::where('vendor_id',Auth::user()->id)->where('status','!=','Disable')->orderBy('category_id','ASC')->get();
        $categories = Category::where('status','Active')->get();
        $offers = Offer::paginate(8);
        return view('vendor.offer_management.index',compact('categories','products','allProducts','offers'));
    }
    public function offerAdd(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'product_ids' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:6144'
        ]);
        foreach ($request->product_ids as $p => $s)
        {
            $insert[]['id'] = $s;
            $limit[] = $request->limit[$p];
        }
        /*foreach ($request->limit as $s2)
        {
            $limit[] = $s2;
        }*/
        $product_ids = json_encode($insert);
        $offer_limit = json_encode($limit);
        if($request->type == 'Buy one get one')
        {
            foreach ($request->free_product_ids as $s)
            {
                $insert2[]['id'] = $s;
            }
            $free_product_ids = json_encode($insert2);
        }
        else
        {
            $free_product_ids = '';
        }

        $image = $request->file('image');
        if(!empty($image))
        {
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('assets/vendor/images/offers/',$image_name);


            $offer =  Offer::create([
                'title' => $request->title,
                'image' => $image_name,
                'type' => $request->type,
                'status' => $request->status,
                'enddate' => $request->enddate,
                'offer_percentage' => $request->offer_percentage,
                'product_ids' => $product_ids,
                'free_product_ids' => $free_product_ids,
                /*'offer_limit' => $offer_limit,*/

            ]);
        }
        else
        {
            $offer =  Offer::create([
                'title' => $request->title,
                'type' => $request->type,
                'status' => $request->status,
                'enddate' => $request->enddate,
                'offer_percentage' => $request->offer_percentage,
                'product_ids' => $product_ids,
                'free_product_ids' => $free_product_ids,
                /*'offer_limit' => $offer_limit,*/

            ]);
        }
//for product table update
        foreach ($request->product_ids as $p => $s)
        {
            $update = Product::find($s);
            if($request->type == 'Discount')
            {
                $oprice = round($update->price - ($update->price*$request->offer_percentage)/100);
                $offer_price = round( $oprice);
                $update->update([
                    'offer_id' => $offer->id,
                    'offer_price' => $offer_price,
                    /*'offer_limit' => $request->limit[$p],*/
                ]);
            }
            elseif ($request->type == 'Buy one get one')
            {
                $update->update([
                    'offer_id' => $offer->id,
                    /*'offer_limit' => $request->limit[$p],*/
                ]);
            }
        }
        return back()->with('msg','✔ Offer Added');
    }
    public function offerManagementEdit($id)
    {
        $oid = Crypt::decrypt($id);
        $offer = Offer::where('id',$oid)->first();
        $categories = Category::where('status','Active')->get();
        $products = Product::where('vendor_id',Auth::user()->id)->where('status','!=','Disable')->orderBy('category_id','ASC')->get();
        return view('vendor.offer_management.edit',compact('offer','categories','products'));
    }
    public function offerUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'product_ids' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $image = $request->file('image');
        $update = offer::find($request->id);
        //product offer id and price null
        $prev_pids = json_decode($update->product_ids);
        foreach ($prev_pids as $s)
        {
            $products = Product::find($s->id);
            $products->update([
                'offer_id' => NULL,
                'offer_price' => NULL,
            ]);
        }
        //product offer id and price null #


        foreach ($request->product_ids as $s)
        {
            $insert[]['id'] = $s;
        }
        $product_ids = json_encode($insert);

        if($update->type == 'Buy one get one')
        {
            foreach ($request->free_product_ids as $s)
            {
                $insert2[]['id'] = $s;
            }
            $free_product_ids = json_encode($insert2);
        }
        else
        {
            $free_product_ids = '';
        }

        if(!empty($image))
        {
            if(!empty($update->image)){unlink('assets/vendor/images/offers/'.$update->image);}
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('assets/vendor/images/offers/',$image_name);

            if($update->type == 'Buy one get one')
            {
                $update->update([
                    'title' => $request->title,
                    'image' => $image_name,
                    'status' => $request->status,
                    // 'enddate' => $request->enddate,
                    'product_ids' => $product_ids,
                    'free_product_ids' => $free_product_ids,
                ]);
            }
            else
            {
                $update->update([
                    'title' => $request->title,
                    'image' => $image_name,
                    'status' => $request->status,
                    // 'enddate' => $request->enddate,
                    'offer_percentage' => $request->offer_percentage,
                    'product_ids' => $product_ids,
                ]);
            }
        }
        else
        {
            if($update->type == 'Buy one get one')
            {
                $update->update([
                    'title' => $request->title,
                    'status' => $request->status,
                    // 'enddate' => $request->enddate,
                    'product_ids' => $product_ids,
                    'free_product_ids' => $free_product_ids,
                ]);
            }
            else
            {
                $update->update([
                    'title' => $request->title,
                    'status' => $request->status,
                    // 'enddate' => $request->enddate,
                    'offer_percentage' => $request->offer_percentage,
                    'product_ids' => $product_ids,
                ]);
            }
        }
        //for product table update
        //alter perv products
        foreach ($prev_pids as $s)
        {
            $update3 = Product::find($s->id);
            if($update->type == 'Discount')
            {
                $update3->update([
                    'offer_id' => NULL,
                    'offer_price' => NULL,
                ]);
            }
            elseif ($update->type == 'Buy one get one')
            {
                $update3->update([
                    'offer_id' => NULL,
                ]);
            }
        }
        //alter perv products #

        //new calc products
        foreach ($request->product_ids as $s)
        {
            $update2 = Product::find($s);
            if($update->type == 'Discount')
            {
                if($request->status == 'Active')
                {
                    $oprice =$update2->price - ($update2->price*$request->offer_percentage)/100;
                    $offer_price = round($oprice);
                    $update2->update([
                        'offer_id' => $request->id,
                        'offer_price' => $offer_price,
                    ]);
                }
                else
                {
                    $update2->update([
                        'offer_id' => NULL,
                        'offer_price' => NULL,
                    ]);
                }
            }
            elseif ($update->type == 'Buy one get one')
            {
                if($request->status == 'Active')
                {
                    $update2->update([
                        'offer_id' => $request->id,
                    ]);
                }
                else
                {
                    $update2->update([
                        'offer_id' => NULL,
                    ]);
                }
            }
        }
        //new calc products #

        return back()->with('msg','✔ Offer Updated');
    }
    public function offerRemove($id)
    {
        $oid = Crypt::decrypt($id);
        $delete = Offer::find($oid);
        if(!empty($delete->image)){unlink('assets/vendor/images/offers/'.$delete->image);}
        $delete->delete();
        return redirect()->back()->with('msg',"✔ REMOVED");
    }
    //************************ page = offer_management #
    //************************ page = inventory_management
    public function inventoryManagementView()
    {
        $products = Product::paginate(8);
        $sub_categories = Category::whereNotNull('parent_id')->get();
        /*foreach ($sub_categories as  $value)
        {
            $sub[] = $value->parent_id;
        }
        $parent_id = NULL;*/
        return view('vendor.inventory_management.index',compact('sub_categories','products'));
    }
    //************************ page = inventory_management #
    //************************ page = oder_management
    public function pendingOrderView()
    {
        $pending_orders = Temp_Order::where('status','Pending')->orderBy('updated_at','DESC')->paginate(18);
        return view('vendor.order_management.pending',compact('pending_orders'));
    }
    public function dueOrderView()
    {
        $due_orders = Temp_Order::where('status','Due')->orderBy('updated_at','DESC')->paginate(18);
        return view('vendor.order_management.due',compact('due_orders'));
    }
    public function dueOrderRemove($id)
    {
        $oid = Crypt::decrypt($id);
        $delete = Temp_Order::find($oid);
        $deletePayment = Payment::find($delete->payment_id);
        $deleteShipping = Shipping::find($delete->shipping_id);
        $delete = Temp_Order::find($oid);
        //work for stock update
        $products = json_decode($delete->product_ids);
        $qty = json_decode($delete->quantity);
        foreach($products as $i=>$s)
        {
            $update = Product::find($s);
            $new_stock = $update->stock + $qty[$i];
            if($update->stock == 0){
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
        $delete->delete();
        if($delete->status == 'Cancel')
        {
            $deletePayment->delete();
            $deleteShipping->delete();
        }
        return redirect()->route('dueOrderView')->with('msg',"✔ REMOVED");
    }
    public function temp_order_details($id)
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
        return view('vendor.order_management.order_details',compact('order','products','selling_price','quantity','offer_type','offer_percentage','free_products'));
    }
    public function orderCancel(Request $request)
    {
        $request->validate([
            'name' => 'required|max:15',
            'reason' => 'required|max:175',
        ]);
        $oid = $request->id;
        $order = Temp_Order::where('id',$oid)->first();
        $order->update([
            'status' => 'Cancel',
            'reason' => $request->name.': '.$request->reason,
        ]);
        return back()->with('msg', "✔ Order Canceled");
        //return view('vendor.product_management.edit',compact('product','imgarray','brands','categories'));
    }
    public function orderShipping(Request $request)
    {
        $request->validate([
            'shipping_tracking_number' => 'required|max:15',
            'courier_name' => 'required|max:150',
            'shipping_date' => 'required',
        ]);
        $oid = $request->id;
        $order = Order::where('id',$oid)->first();
        $shipping = Shipping::where('id',$order->shipping_id)->first();
        $order->update([
            'status' => 'Shipping',
        ]);
        $shipping->update([
            'shipping_tracking_number' => $request->shipping_tracking_number,
            'courier_name' => $request->courier_name,
            'shipping_date' => $request->shipping_date,
        ]);
        return back()->with('msg', "✔ ".$request->order_id." Updated ");
    }
    public function orderProceed($id)
    {
        $oid = Crypt::decrypt($id);
        $temp_order = Temp_Order::where('id',$oid)->first();
        $order =  Order::create([
            'customer_id' => $temp_order->customer_id,
            'shipping_id' => $temp_order->shipping_id,
            'payment_id' => $temp_order->payment_id,
            'invoice_id' => $temp_order->invoice_id,
            'product_ids' => $temp_order->product_ids,
            'selling_price' => $temp_order->selling_price,
            'quantity' => $temp_order->quantity,
            'offer_type' => $temp_order->offer_type,
            'offer_percentage' => $temp_order->offer_percentage,
            'free_product_ids' => $temp_order->free_product_ids,
            'subtotal' => $temp_order->subtotal,
            'total' => $temp_order->total,
            'status' => 'Processing',
            'reason' => $temp_order->reason,
            'slug' => $temp_order->slug,
        ]);
//delete temp_orders
        $temp_order->delete();
        return redirect()->route('pendingOrderView')->with('msg', "✔ Order Proceed");

        //return view('vendor.product_management.edit',compact('product','imgarray','brands','categories'));
    }
    public function OrderView()
    {
        $orders = Order::orderBy('Status','DESC')->paginate(18);
        return view('vendor.order_management.order',compact('orders'));
    }
    public function orderDelivered($id)
    {
        $oid = Crypt::decrypt($id);
        $order = Order::where('id',$oid)->first();
        $order->update(['status' => 'Delivered']);
        return back()->with('msg', "✔ Order Delivered");
    }
    public function orderProcessiong($id)
    {
        $oid = Crypt::decrypt($id);
        $order = Order::where('id',$oid)->first();
        $order->update(['status' => 'Processing']);
        return back()->with('msg', "✔ Order Updated");
    }
    public function cancelOrderView()
    {
        $cancel_orders = Temp_Order::where('status','Cancel')->orderBy('updated_at','DESC')->paginate(18);
        return view('vendor.order_management.cancel',compact('cancel_orders'));
    }
    public function order_details($id)
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

        return view('vendor.order_management.order_details',compact('order','products','selling_price','quantity','offer_type','offer_percentage','free_products'));
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|max:20',
            'sender_mobile_number' => 'required|max:15',
        ]);
        $oid = $request->id;
        if($request->orderfor == 'temp')
        {
            $order = Temp_Order::where('id',$oid)->first();
            $payment = Payment::where('id',$order->payment_id);
            $order->update([
                'trx_id' => $request->trx_id,
                'sender_mobile_number' => $request->sender_mobile_number,
            ]);
            $payment->update([
                'trx_id' => $request->trx_id,
                'sender_mobile_number' => $request->sender_mobile_number,
            ]);
        }
        elseif($request->orderfor == 'main')
        {
            $order = Order::where('id',$oid)->first();
            $payment = Payment::where('id',$order->payment_id);
            $order->update([
                'trx_id' => $request->trx_id,
                'sender_mobile_number' => $request->sender_mobile_number,
            ]);
            $payment->update([
                'trx_id' => $request->trx_id,
                'sender_mobile_number' => $request->sender_mobile_number,
            ]);
        }

        return back()->with('msg', "✔ Payment Updated for ");
        //return view('vendor.product_management.edit',compact('product','imgarray','brands','categories'));
    }
    public function generateInvoice($id)
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

        $pdf = PDF::loadView('pdf/pdf', compact('order','products','selling_price','quantity','offer_type','offer_percentage','free_products','address'));
        return $pdf->stream('order :'.$order->invoice_id.'.pdf');
    }

    public function search(Request $request)
    {
        $search = $_GET['search'];
        $type = $_GET['type'];
        if($type == 'temp')
        {
            if(!empty($search))
            {
                $search_result = Temp_Order::where('invoice_id','LIKE','%'.$search.'%')->orWhere('trx_id','LIKE','%'.$search.'%')->orWhere('sender_mobile_number','LIKE','%'.$search.'%')->orWhere('status','LIKE','%'.$search.'%')->get();
                $search_count = $search_result->count();
                $count = $search_count.' records found';
            }
            else
            {
                $search_result = Temp_Order::whereIn('status',['Pending','Cancel'])->orderBy('updated_at','DESC')->get();
                $search_count = $search_result->count();
                $count = '';
            }
        }
        elseif($type == 'main')
        {
            if(!empty($search))
            {
                $search_result = Order::where('invoice_id','LIKE','%'.$search.'%')->orWhere('status','LIKE','%'.$search.'%')->get();
                $search_count = $search_result->count();
                $count = $search_count.' records found';
            }
            else
            {
                $search_result = Order::whereIn('status',['Delivered','Shipping','Processing'])->orderBy('updated_at','DESC')->get();
                $search_count = $search_result->count();
                $count = '';
            }
        }
        elseif($type == 'product')
        {
            if (!empty($search))
            {
                $search_product = Product::where('name', 'LIKE', '%' . $search . '%')->get();
                foreach ($search_product as $p) {
                    $product_array[] = $p->id;
                }
                $orders = Order::orderBy('status','DESC')->get();
                $search_result = [];
                foreach ($orders as $o)
                {
                    $order_pid = json_decode($o->product_ids);
                    $result = array_intersect($order_pid, $product_array);
                    if (!empty($result))
                    {
                        $search_result[] = $o;
                    }
                }
                $search_count = count($search_result);
                $count = $search_count . ' records found';
            }
            else
            {
                $search_result = Order::whereIn('status',['Delivered','Shipping','Processing'])->orderBy('updated_at','DESC')->get();
                $search_count = 0;
                $count = '';
            }
        }
        $returnHTML = view('vendor.order_management.search')->with('search_result', $search_result)->with('search_count', $search_count)->render();
        return response()->json(array('success' => true, 'table_data'=>$returnHTML,'total_data'=>$count));
    }
    public function allOrders()
    {
        return view('vendor.order_management.index');
    }
    public function orderReport(Request $request)
    {
        $dateRange = $request->daterange;
        $date = explode('-', $dateRange);
        $from = date('Y-m-d 00:00:00', strtotime($date[0]));
        $to = date('Y-m-d 23:59:59', strtotime($date[1]));
        $orders = Order::whereBetween('created_at', [$from, $to])->orderBy('Status','DESC')->paginate(18);;
        return view('vendor.order_management.order',compact('orders'));
    }
    //************************ page = oder_management #

    //************************ page = customer_management
    public function customerList()
    {
        $customerList = Customer::get();

        return view('vendor.customer_management.index',compact('customerList'));
    }
    public function customer_details($id)
    {
        $cid = Crypt::decrypt($id);
        $customer = Customer::where('id',$cid)->first();
        $temp_orders = Temp_Order::where('customer_id',$customer->id)->get();
        $orders = Order::where('customer_id',$customer->id)->get();
        return view('vendor.customer_management.customer_details',compact('customer','temp_orders','orders'));
    }
    public function searchCustomer(Request $request)
    {
        $search = $_GET['search'];
            if(!empty($search))
            {
                $search_result = Customer::where('name','LIKE','%'.$search.'%')->orWhere('email','LIKE','%'.$search.'%')->orWhere('address','LIKE','%'.$search.'%')->orWhere('city','LIKE','%'.$search.'%')->orWhere('phone','LIKE','%'.$search.'%')->get();
                $search_count = $search_result->count();
                $count = $search_count.' records found';
            }
            else
            {
                $search_result = Customer::orderBy('id','ASC')->get();
                $search_count = $search_result->count();
                $count = '';
            }
        $returnHTML = view('vendor.customer_management.search')->with('search_result', $search_result)->with('search_count', $search_count)->render();
        return response()->json(array('success' => true, 'table_data'=>$returnHTML,'total_data'=>$count));
    }
    //************************ page = customer_management #
    //************************ page = contact_management
    public function contact_management()
    {
        $ask_a_question = Contact::where('type','ask_a_question')->orderByDesc("status")->get();
        $complain = Contact::where('type','complain')->get();
        $suggestion = Contact::where('type','suggestion')->get();
        $contact = Contact::where('type','contact')->get();
        return view('vendor.contact_management.index',compact('ask_a_question','complain','suggestion','contact'));
    }

    public function contact_details($id)
    {
        $contact = Contact::find(Crypt::decrypt($id));
        return view('vendor.contact_management.details',compact('contact'));
    }

    public function contact_delete($id)
    {
        Contact::find(Crypt::decrypt($id))->delete();
        return redirect()->back();
    }

    public function contact_processing($id)
    {
        $update = Contact::find(Crypt::decrypt($id));
        $update->update([
            'status' => 'Processing',
        ]);
        return redirect()->back();
    }

    public function contact_solved($id)
    {
        $update = Contact::find(Crypt::decrypt($id));
        $update->update([
            'status' => 'Solved',
        ]);
        return redirect()->back();
    }

    public function contact_cancel($id)
    {
        $update = Contact::find(Crypt::decrypt($id));
        $update->update([
            'status' => 'Cancelled',
        ]);
        return redirect()->back();
    }

    public function contact_note_update(Request $request)
    {
        $id = $request->id;
        $update = Contact::find($id);
        $update->update([
            'note' => $request->note
        ]);
        return redirect()->back();
    }

    public function contact_search()
    {
        $search = $_GET['search'];
        $search_contact = Contact::where('name','LIKE','%'.$search.'%')
                                 ->orWhere('email','LIKE','%'.$search.'%')
                                 ->orWhere('phone','LIKE','%'.$search.'%')
                                 ->orWhere('address','LIKE','%'.$search.'%')
                                 ->orWhere('type','LIKE','%'.$search.'%')
                                 ->orWhere('message','LIKE','%'.$search.'%')
                                 ->orWhere('status','LIKE','%'.$search.'%')
                                 ->get();
        $returnHTML = view('vendor.contact_management.search_table')->with('search_contacts', $search_contact)->render();
        return response()->json(array('success' => true, 'search_contact'=> $returnHTML ));
    }
     //************************ page = contact_management #
    //************************ page = sales_management
    public function sales()
    {
        $products = Product::orderby('category_id','ASC')->get();
        $orders = Order::get();
        foreach($products as $pi => $p)
        {//products
            $soldTotal=0;$amountTotal=0; $OffersoldTotal=0;$OfferamountTotal=0;
            foreach ($orders as $o)
            {//orders
                $pid = json_decode($o->product_ids);
                foreach($pid as $i => $pid)
                {//product_ids
                    if($p->id == $pid)
                    {
                        $spelling_price = json_decode($o->selling_price);
                        $quantity = json_decode($o->quantity);
                        $offer_type = json_decode($o->offer_type);
                        $offer_percentage = json_decode($o->offer_percentage);
                        $soldTotal +=  (int)$quantity[$i];
                        $amountTotal +=  (int)$spelling_price[$i] * $quantity[$i];
                        if($offer_type[$i] != NULL)
                        {
                            $OffersoldTotal +=  (int)$quantity[$i];
                            $OfferamountTotal +=  (int)$spelling_price[$i] * $quantity[$i];
                        }
                        //echo $$soldTotal;
                    }
                }
            }
            $productSoldTotal[] = $soldTotal;
            $productAmountTotal[] = $amountTotal;
            $OfferProductSoldTotal[] = $OffersoldTotal;
            $OfferProductAmountTotal[] = $OfferamountTotal;
        }
        return view('vendor.sales_management.index',compact('products','productSoldTotal','productAmountTotal','OfferProductSoldTotal','OfferProductAmountTotal'));
    }
    public function salesReport(Request $request)
    {
        $dateRange = $request->daterange;
        //echo $dateRange;
        $date = explode('-',$dateRange);
        $from = date('Y-m-d 00:00:00', strtotime($date[0]));
        $to = date('Y-m-d 23:59:59', strtotime($date[1]));
        //echo $from."-".$to;
        $products = Product::orderby('category_id','ASC')->get();
        $orders = Order::whereBetween('created_at', [$from , $to])->get();
        foreach($products as $pi => $p)
        {//products
            $soldTotal=0;$amountTotal=0; $OffersoldTotal=0;$OfferamountTotal=0;
            foreach ($orders as $o)
            {//orders
                $pid = json_decode($o->product_ids);
                foreach($pid as $i => $pid)
                {//product_ids
                    if($p->id == $pid)
                    {
                        $spelling_price = json_decode($o->selling_price);
                        $quantity = json_decode($o->quantity);
                        $offer_type = json_decode($o->offer_type);
                        $offer_percentage = json_decode($o->offer_percentage);
                        $soldTotal +=  (int)$quantity[$i];
                        $amountTotal +=  (int)$spelling_price[$i] * $quantity[$i];
                        if($offer_type[$i] != NULL)
                        {
                            $OffersoldTotal +=  (int)$quantity[$i];
                            $OfferamountTotal +=  (int)$spelling_price[$i] * $quantity[$i];
                        }
                        //echo $$soldTotal;
                    }
                }
            }
            $productSoldTotal[] = $soldTotal;
            $productAmountTotal[] = $amountTotal;
            $OfferProductSoldTotal[] = $OffersoldTotal;
            $OfferProductAmountTotal[] = $OfferamountTotal;
        }
        return view('vendor.sales_management.index',compact('products','productSoldTotal','productAmountTotal','OfferProductSoldTotal','OfferProductAmountTotal'));
    }
    //************************ page = sales_management #

}
