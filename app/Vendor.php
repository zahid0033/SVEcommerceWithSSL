<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use test\Mockery\HasUnknownClassAsTypeHintOnMethod;


class Vendor extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name','email','password','type','status','image','slug','gender'];
    protected $table = 'vendors';

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function brands()
    {
        return $this->hasOne(Brand::class,'vendor_id');
    }

}
