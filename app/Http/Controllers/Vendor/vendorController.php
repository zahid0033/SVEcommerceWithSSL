<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class vendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(Auth::user()->type == 'Normal')
        {
            return redirect('dashboard');
        }
        elseif(Auth::user()->type == 'Moderator')
        {
            return redirect('order_management/allorders');
        }
        elseif(Auth::user()->type == 'Installment_Mod')
        {
            return redirect('installment');
        }
        else
        {
            return redirect('logout');
        }
    }
}
