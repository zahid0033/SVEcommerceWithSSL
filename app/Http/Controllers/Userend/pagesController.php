<?php

namespace App\Http\Controllers\Userend;

use App\Category;
use App\Product;
use App\Offer;
use App\Temp_Order;
use Cart;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class pagesController extends Controller
{
    public function home()
    {
        $categories = Category::where('parent_id',null)->take(6)->get();
        $products = Product::all();
        return view('pages.home',compact('products','categories'));

    }

    public function products()
    {
        $cart_datas = Cart::content();
        $products = Product::where('status','!=','Disable')->paginate(14);
        return view('pages.products',compact('products','cart_datas'));
    }

    public function single_product($id)
    {
        $single_id = Crypt::decrypt($id);
        $product_single = Product::where('id',$single_id)->get();
//        dd($product_single);
        return view('pages.single_product',compact('product_single'));
    }

    /*public function checkout()
    {
        $cart_datas = Cart::content();
        return view('pages.checkout',compact('cart_datas'));
    }*/

    public function single()
    {
        return view('pages.tshirt');
    }

    public function subCatgProductSearch($id)
    {
        $subCatg_id = Crypt::decrypt($id);
        $products = Product::where('category_id',$subCatg_id)->paginate(14);
        return view('pages.products',compact('products'));
    }

    public function offerSearchByTitle($id)
    {
        $offer_id = Crypt::decrypt($id);
        $products = Product::where('offer_id',$offer_id)->paginate(14);
        return view('pages.products',compact('products'));
    }

    public function allOfferSearch()
    {
        $products = Product::where('offer_id','!=',null)->paginate(14);
        return view('pages.products',compact('products'));
    }



}
