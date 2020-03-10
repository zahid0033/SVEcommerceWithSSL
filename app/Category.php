<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','description','image','status','parent_id','slug'];
    protected $table = 'categories';

    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }

}
