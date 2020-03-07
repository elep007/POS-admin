<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = "machines";
    protected $fillable = [
        'id', 'machine_name', 'category'
    ];
    public $timestamps = false;



    public function line_prod()
    {
        return $this->hasOne('App\LineProd', 'machine_id', 'id');
    }



    public static function getMachines($pageNum, $searchKey){
        $limit = 10;
        $start = ($pageNum - 1) * $limit;

        $order = 'category';
        $dir = 'asc';

        $totalData = Machine::count();
        $totalFiltered = $totalData;

        if(empty($searchKey))
        {
            $users = Machine::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $searchKey;
            $users =  Machine::where('machine_name','LIKE',"%{$search}%")
                //->orWhere('email', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered =  Machine::where('machine_name','LIKE',"%{$search}%")->count();

        }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $item)
            {
                $nestedData['machine_id'] = $item->id;
                $nestedData['machine_name'] = $item->machine_name;
                $nestedData['category'] = $item->category;
                $downtimesdata = MachineDowntime::where('machine_id', $item->id)->orderBy('start_downtime', 'desc');

                if ($downtimesdata->exists()){
                    $nestedData['status'] = $downtimesdata->first()->status;
                    $nestedData['mttr'] = Machine::get_time_interval(($downtimesdata->first()->mean_time_to_recover));
                    $nestedData['at'] = Machine::get_time_interval(($downtimesdata->first()->total_engineer_arrival_time));
                    $nestedData['slt'] = Machine::get_time_interval(($downtimesdata->first()->supplier_lead_time));
                    $nestedData['downTime'] = $downtimesdata->first()->start_downtime;
                    $nestedData['arrivalTime'] = $downtimesdata->first()->engineer_arrival_time;
                    $nestedData['pauseTime'] =$downtimesdata->first()->pause_downtime;
                    $nestedData['resumeTime'] =$downtimesdata->first()->resume_downtime;
                    $nestedData['resolvedTime'] =$downtimesdata->first()->end_downtime;
                }else{
                    $nestedData['status'] = 'Normal';
                    $nestedData['mttr'] = Machine::get_time_interval(0);
                    $nestedData['at'] = Machine::get_time_interval(0);
                    $nestedData['slt'] = Machine::get_time_interval(0);
                    $nestedData['downTime'] = null;
                    $nestedData['arrivalTime'] = null;
                    $nestedData['pauseTime'] = null;
                    $nestedData['resumeTime'] = null;
                    $nestedData['resolvedTime'] = null;
                }

                $data[] = $nestedData;
            }
        }

        $totalPage =  ceil($totalFiltered / $limit);
        $json_data['machines'] = $data;
        $json_data["totalPage"] = $totalPage;
        return $json_data;
    }







    static function get_time_interval($time_differnce)
    {
        $years = 60*60*24*365;
        $months = 60*60*24*30;
        $days = 60*60*24;
        $hours = 60*60;
        $minutes = 60;
        if(intval($time_differnce/$years) > 1)
        {
            return intval($time_differnce/$years)." years";
        }else if(intval($time_differnce/$years) > 0)
        {
            return intval($time_differnce/$years)." year";
        }else if(intval($time_differnce/$months) > 1)
        {
            return intval($time_differnce/$months)." months";
        }else if(intval(($time_differnce/$months)) > 0)
        {
            return intval(($time_differnce/$months))." month";
        }else if(intval(($time_differnce/$days)) > 1)
        {
            return intval(($time_differnce/$days))." days";
        }else if (intval(($time_differnce/$days)) > 0)
        {
            return intval(($time_differnce/$days))." day";
        }else if (intval(($time_differnce/$hours)) > 1)
        {
            return intval(($time_differnce/$hours))." hrs";
        }else if (intval(($time_differnce/$hours)) > 0)
        {
            return intval(($time_differnce/$hours))." hr";
        }else if (intval(($time_differnce/$minutes)) > 1)
        {
            return intval(($time_differnce/$minutes))." mins";
        }else if (intval(($time_differnce/$minutes)) > 0)
        {
            return intval(($time_differnce/$minutes))." min";
        }else if (intval(($time_differnce)) > 1)
        {
            return intval(($time_differnce))." secs";
        }else
        {
            return "0";
        }
    }





}
