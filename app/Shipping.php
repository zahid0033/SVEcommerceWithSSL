<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['customer_id','name','email','address','city','phone','shipping_tracking_number','courier_name','shipping_date','slug'];
    protected $table = 'shippings';

    public function temp_orders()
    {
        return $this->hasOne(Temp_Order::class,'shipping_id');
    }

    public function orders()
    {
        return $this->hasOne(Order::class,'shipping_id');
    }
}
