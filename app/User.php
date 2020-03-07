<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'encriptp'
    ];

    public $timestamps = false;



    public static function getUsers($user_id ,$pageNum, $searchKey){
        $limit = 10;
        $start = ($pageNum - 1) * $limit;

        $order = 'username';
        $dir = 'asc';

        $totalData = User::count();
        $totalFiltered = $totalData;

        if(empty($searchKey))
        {
            $users = User::where('id', '<>', $user_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $searchKey;
            $users =  User::where('id', '<>', $user_id)
                ->where('username','LIKE',"%{$search}%")
                //->orWhere('email', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();


            $totalFiltered =  User::where('id', '<>', $user_id)
                ->where('username','LIKE',"%{$search}%")
                //->orWhere('email', 'LIKE',"%{$search}%")
                ->count();

        }

        $data = array();


        if(!empty($users))
        {
            foreach ($users as $item)
            {
                $nestedData['user_id'] = $item->id;
                $nestedData['username'] = $item->username;
                $nestedData['avatar'] = $item->avatar;
                $nestedData['email'] = $item->email;

                $data[] = $nestedData;
            }
        }

        $totalPage =  ceil($totalFiltered / $limit);
        $json_data['users'] = $data;
        $json_data["totalPage"] = $totalPage;
        return $json_data;
    }



}
