<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = "shop";
    protected $fillable = [
        'id', 'shop_id', 'shop_name', 'phone', 'address'
    ];
    public $timestamps = false;
}
