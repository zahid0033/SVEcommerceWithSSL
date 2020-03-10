<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp_Order extends Model
{
    protected $fillable = ['customer_id','shipping_id','payment_id','vendor_id','invoice_id','product_ids','selling_price','quantity','offer_type','offer_percentage','free_product_ids','trx_id','sender_mobile_number','status','reason','subtotal','total'];
    protected $table = 'temp_orders';

    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function shippings()
    {
        return $this->belongsTo(Shipping::class,'shipping_id');
    }

    public function payments()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }
}
