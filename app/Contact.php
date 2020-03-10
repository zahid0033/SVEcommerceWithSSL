<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name','email','phone','address','type','message','note','status'];
    protected $table = 'contacts';
}
