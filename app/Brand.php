<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['vendor_id','name','address','phone','email','description','image','status','slug'];
    protected $table = 'brands';

    public function products()
    {
        return $this->hasMany(Product::class,'brand_id');
    }

    public function vendors()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
