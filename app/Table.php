<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = "table";
    protected $fillable = [
        'table_id', 'table_name',
    ];
    public $timestamps = false;


    public static function getTables($user_id ,$pageNum, $searchKey){
        $limit = 10;
        $start = ($pageNum - 1) * $limit;

        $order = 'table_name';
        $dir = 'asc';

        $totalData = Table::count();
        $totalFiltered = $totalData;

        if(empty($searchKey))
        {
            $users = Table::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $searchKey;
            $users =  Table::where('table_name','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();


            $totalFiltered =  Table::where('table_name','LIKE',"%{$search}%")
                ->count();

        }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $item)
            {
                $nestedData['table_id'] = $item->table_id;
                $nestedData['table_name'] = $item->table_name;
                $data[] = $nestedData;
            }
        }

        $totalPage =  ceil($totalFiltered / $limit);
        $json_data['tables'] = $data;
        $json_data["totalPage"] = $totalPage;
        return $json_data;
    }



    public static function getListTatble($user_id){

        $data = Table::get();
        $json_data['tables'] = $data;
        return $json_data;
    }





}
