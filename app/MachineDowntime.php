<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineDowntime extends Model
{
    protected $table = "downtimes";
    protected $fillable = [
        'id', 'username','machine_id', 'machine_name', 'start_downtime', 'end_downtime', 'pause_downtime', 'resume_downtime',
        'engineer_arrival_time', 'total_engineer_arrival_time', 'mean_time_to_recover', 'total_down_time', 'supplier_lead_time', 'status', 'category'
    ];
    public $timestamps = false;


}
