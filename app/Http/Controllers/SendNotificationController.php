<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SendNotificationController extends Controller
{

    public function sendNotificationToAll($sender_img_url, $sender_id, $sender_username, $content_id, $content, $parent_id, $parent_content, $parent_img_url, $notification_type){
        $serverKey = "AAAAEtA7GWM:APA91bFs8EGXAu6SgenCibEt8t_7W-NYWU5u3f5fsTC4D2Li8gSuGs-ZBxmXl9n233W_4r73m7QGci1aN6-SL7qu-_W6YC-VwUXhG-fGbXqVW64CtvbpjPzyOC2yeyBUTbTvoHGO-q5K";
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array();

        $fields['data'] = array(
            'sender_img_url'  => $sender_img_url,
            'sender_id'  => $sender_id,
            'sender_username'  => $sender_username,
            'content_id' => $content_id,
            'content' => $content,
            'parent_id' => $parent_id,
            'parent_content'  => $parent_content,
            'parent_img_url' => $parent_img_url, //if post, this will be thumnail of youtube, otherwise image of question
            'type' => $notification_type,
            'unreadCnt' => 1,
            'topic'=>'All'
        );


        $fields['to'] = "/topics/All";

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$serverKey
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);



        return $result;

    }
    public function sendNotificationToAll_IOS($sender_img_url, $sender_id, $sender_username, $content_id, $content, $parent_id, $parent_content, $parent_img_url, $notification_type){


        $serverKey = "AAAA5DksT00:APA91bE5MmmjlNJIkpdx8Al3Ok62sL1Kpe-WGDCRgK-f8mWsQ5ecYVxtuk1u2BPXP_6WL-Ppt122IHIguU5XLxTy3Ynx800gMbc1rt0AOycm7hEEZ9paMBhmJMToioPMk7C-o14zKnTh";
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array();

        $fields['notification'] = array(
            'title' => 'Heavykiwi',
            'body' => $sender_username." posted on ".$parent_content,
            'sound' => 'default',
            'badget' => '0');

        $fields['data'] = array(
            'sender_img_url'  => $sender_img_url,
            'sender_id'  => $sender_id,
            'sender_username'  => $sender_username,
            'content_id' => $content_id,
            'content' => $content,
            'parent_id' => $parent_id,
            'parent_content'  => $parent_content,
            'parent_img_url' => $parent_img_url, //if post, this will be thumnail of youtube, otherwise image of question
            'type' => $notification_type,
            'unreadCnt' => 1,
            'topic'=>'ALL_IOS'
        );


        $fields['to'] = "/topics/ALL_IOS";

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$serverKey
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;

    }




    public function sendNotificationToSpecifyUsers($sender_id, $sender_username, $project_id, $project_name, $option_id,  $receiver_ids, $id)
    {
        $mytime = Carbon::now();
        $serverKey = "AAAAEtA7GWM:APA91bFs8EGXAu6SgenCibEt8t_7W-NYWU5u3f5fsTC4D2Li8gSuGs-ZBxmXl9n233W_4r73m7QGci1aN6-SL7qu-_W6YC-VwUXhG-fGbXqVW64CtvbpjPzyOC2yeyBUTbTvoHGO-q5K";
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array();
        $fields['data'] = array(
            'sender_id'  => $sender_id,
            'sender_username'  => $sender_username,
            'project_id' => $project_id,
            'project_name' => $project_name,
            'option_id' => $option_id,
            'content' => "$project_name". 'was posted '.$this->time_elapsed_string($mytime),
            'topic'=>'individual',
            'receiver_id'=>$receiver_ids,
            'noti_dt'=>$this->time_elapsed_string($mytime)
        );
        $fields['to'] = "/projects/individual_".$id;

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $serverKey
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);


        return $result;
    }






    function time_elapsed_string($datetime, $full = false)
    {
        $now = new \DateTime();
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }







    public function sendNotificationByFcm($registrationIds, $title, $subtitle){

        $serverKey = "AAAAEtA7GWM:APA91bFs8EGXAu6SgenCibEt8t_7W-NYWU5u3f5fsTC4D2Li8gSuGs-ZBxmXl9n233W_4r73m7QGci1aN6-SL7qu-_W6YC-VwUXhG-fGbXqVW64CtvbpjPzyOC2yeyBUTbTvoHGO-q5K";
//        $fcmRegIds = array();
//        $tokens = User::select(['fcm_token'])->get();
//        foreach ($tokens as $item){
//            array_push($fcmRegIds, $item->fcm_token);
//        }
//        $registrationIds = $fcmRegIds;

        // prep the bundle
        $msg = array
        (
            'message' 	=> 'here is a message. message',
            'title'		=> $title,
            'subtitle'	=> $subtitle,
            'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
            'vibrate'	=> 1,
            'sound'		=> 1,
            'largeIcon'	=> 'large_icon',
            'smallIcon'	=> 'small_icon'
        );
        $fields = array
        (
            'registration_ids' 	=> $registrationIds,
            'data'			=> $msg
        );

        $headers = array
        (
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        //echo $result;
    }
}
