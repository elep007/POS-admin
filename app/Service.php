<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = "service_charge";
    protected $fillable = [
        'service_key','service_value',
    ];
    public $timestamps = false;
}
