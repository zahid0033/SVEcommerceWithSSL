<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','brand_id','vendor_id','offer_id','name','specification','description','stock','image','price','offer_price','size_capacity','model','offer_limit','color','status','slug'];
    protected $table = 'products';

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function offers()
    {
        return $this->belongsTo(Offer::class,'offer_id');
    }
}
