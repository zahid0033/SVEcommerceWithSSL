<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstallmentOrder extends Model
{
    protected $fillable = ['product_id','customer_id','product_price','reduced_price','downPayment','due_amount','paid_amount','time_difference','installment_amount','installment_number','installment_dates','payment_dates','installment_status','installment_note','status','call_status','call_note'];
    protected $table = 'installment_orders';

    public function installmentCustomers()
    {
        return $this->belongsTo(InstallmentCustomer::class,'customer_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
