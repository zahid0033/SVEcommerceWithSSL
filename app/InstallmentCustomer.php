<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstallmentCustomer extends Model
{
    protected $fillable = ['name','email','phone','address'];
    protected $table = 'installment_customers';

    public function installmentOrders()
    {
        return $this->hasMany(InstallmentOrder::class,'customer_id');
    }
}
