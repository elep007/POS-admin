<?php

namespace App\Http\Controllers;

use App\Machine;
use App\MachineDowntime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OEEController extends Controller
{
    public function index(){

        $ratio = 60 * 60;
        $downtime = [];
        $slt = [];
        $mttr = [];
        $uptime = [];

        for ($i = 0; $i < 12; $i++){

            $downtime[$i] =  round(MachineDowntime::whereYear('end_downtime', Carbon::now()->year)
                ->whereMonth('end_downtime', $i + 1)
                ->sum('total_down_time') / $ratio, 2);
            $slt[$i] =  round(MachineDowntime::whereYear('end_downtime', Carbon::now()->year)
                    ->whereMonth('end_downtime', $i + 1)
                    ->sum('supplier_lead_time') / $ratio, 2);

            $mttr[$i] =  round(MachineDowntime::whereYear('end_downtime', Carbon::now()->year)
                    ->whereMonth('end_downtime', $i + 1)
                    ->sum('mean_time_to_recover') / $ratio, 2);

            $uptime[$i] =  100 - $downtime[$i];
        }



        return view("oee", ['downtime'=>json_encode($downtime), 'slt' => json_encode($slt), 'mttr'=>json_encode($mttr), 'uptime' =>json_encode($uptime)]);
    }



    public function getMachines(Request $request){
        $category = $request->category;

        $machines = Machine::where('category', $category)->get();

        $data = array();
        if(!empty($machines))
        {
            foreach ($machines as $item)
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

        $data = [
            'results' => $data,
            'error_code' => 0,
            'error_message' => ''
        ];
        return $data;
    }


    public function getGroups(Request $request){
        $categories = Machine::select(['category'])->distinct()->get();

        $data = [
            'results' => $categories,
            'error_code' => 0,
            'error_message' => ''
        ];
        return $data;

    }



    public function getLineHealthy(Request $request){
        $today = Carbon::now();

        $category = $request->category;
        $totalDowntimePerLine = MachineDowntime::where('category', $category)->sum('total_down_time');
        $totalHourPerLine = Machine::where('category', $category)->count() * 24 * 3600 * $this->get_time_difference_php('2019-07-01 16:55:07', $today);

        $lineHealthy = 100 * ($totalHourPerLine - $totalDowntimePerLine) / $totalHourPerLine;

        $data = [
            'results' => round($lineHealthy, 2),
            'error_code' => 0,
            'error_message' => ''
        ];
        return $data;

    }


    public function factoryHealthy(Request $request){
        $today = Carbon::now();
        $totalDowntimePerLine = MachineDowntime::sum('total_down_time');
        $totalHourPerLine = Machine::count() * 24 * 3600 * $this->get_time_difference_php('2019-07-01 16:55:07', $today);
        $factoryHealthy = 100 * ($totalHourPerLine - $totalDowntimePerLine) / $totalHourPerLine;
        $data = [
            'results' => round($factoryHealthy, 2),
            'error_code' => 0,
            'error_message' => ''
        ];
        return $data;

    }


    function get_time_difference_php($start_time, $end_time)
    {
        //date_default_timezone_set('Europe/Edinburgh'); //Change as per your default time
        $str = strtotime($start_time);
        $end_time = strtotime($end_time);
        $time_differnce = $end_time-$str;
        $years = 60*60*24*365;
        $months = 60*60*24*30;
        $days = 60*60*24;
        $hours = 60*60;
        $minutes = 60;
        return intval(($time_differnce/$days));
    }





}
