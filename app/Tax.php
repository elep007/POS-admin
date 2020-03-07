<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = "tax_code";
    protected $fillable = [
        'tax_code','tax_percentage',
    ];
    public $timestamps = false;
}
