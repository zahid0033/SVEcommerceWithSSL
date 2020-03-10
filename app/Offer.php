<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['title','type','product_ids','offer_percentage','free_product_ids','offer_limit','image','enddate','status','slug'];
    protected $table = 'offers';

    public function products()
    {
        return $this->hasMany(Product::class,'offer_id');
    }
}
