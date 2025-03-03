<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class normalVendorCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->type == 'Normal' or Auth::user()->type == 'Installment_Mod')
        {
            return $next($request);
        }
        else
        {
           /* return back()->with('msg','⚠ Invalid Request');*/
            return redirect()->back()->with('msg','⚠ Restricted ');
        }
    }
}
