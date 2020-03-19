<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['status','invoice_id','amount','store_amount','bank_tran_id','tran_date','currency','currency_type','currency_amount','currency_rate','base_fair','card_type','card_no','card_issuer','card_brand','card_issuer_country','card_issuer_country_code','error','slug'];
    protected $table ='payments';

    public function orders()
    {
        return $this->hasOne(Order::class,'payment_id');
    }

    public function temp_orders()
    {
        return $this->hasOne(Temp_Order::class,'payment_id');
    }
}
