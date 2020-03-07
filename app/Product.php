<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $fillable = [
        'product_id', 'product_name', 'product_description', 'tax_code', 'photo', 'category_id', 'shop_id'
    ];
    public $timestamps = false;
}
