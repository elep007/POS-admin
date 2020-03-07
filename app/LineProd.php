<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineProd extends Model
{
    protected $table = "line_prods";
    protected $fillable = [
        'id', 'machine_id', 'line_production'
    ];
    public $timestamps = false;

}
