<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineProduction extends Model
{
    protected $table = "line_productions";
    protected $fillable = [
        'id', 'line_production', 'account_id'
    ];
    public $timestamps = false;

}
