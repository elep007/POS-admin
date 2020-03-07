<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('dashboard');
    }



    public function sendSms(){
        //$id=$_GET['id'];
        $id = '8615604159044';
        $account_sid = 'AC41911dceabb0e8d66dfb0f3041a8d1a4';
        $auth_token = '546e1a8504ac0fb90f7c58511348a454';

        $twilio_number = "+19794727768";
        echo  $random=rand ( 10000 , 99999 );;
//$phon="+923424166764
        $client = new Client($account_sid, $auth_token);

        $client->messages->create(
            "+".$id,
            array( 'from' => $twilio_number, 'body' => 'Your verification Code is '.$random)
        );
    }
    }

