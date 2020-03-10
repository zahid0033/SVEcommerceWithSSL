<?php

namespace App\Http\Controllers\Website;


use App\Category;
use App\Contact;
use App\Offer;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class websiteController extends Controller
{

    public function index()
    {
        $offers = Offer::where('status','!=','Deactive')->get();
        $categories = Category::where('parent_id','!=', null)->take(8)->get();
        return view('website.pages.index',compact('categories','offers'));
    }

    public function about()
    {
        return view('website.pages.about');
    }


    public function offers()
    {
        $offers = Offer::where('status','!=','Deactive')->get();
        return view('website.pages.offers',compact('offers'));
    }

    public function contact_us()
    {
        return view('website.pages.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'message' => 'required'
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'type' => $request->type,
            'message' => $request->message,
            'status' => 'Pending',
        ]);

        return back()->with('msg','✔ We will contact though your Phone or Email');
    }
}
