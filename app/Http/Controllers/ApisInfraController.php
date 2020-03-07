<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tax;
use App\Discount;
use App\Service;
use App\ChatContact;
use App\FileModel;
use App\LineProduction;
use App\Machine;
use App\MachineDowntime;
use App\Notification;
use App\Option;
use App\Product;
use App\ProjectPermission;
use App\Relation;
use App\Table;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\User;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class ApisInfraController extends Controller
{

    public function signup(Request $request)
    {
        $username = $request['username'];
        $email = $request['email'];
        $password = $request['password'];
        $shop_id = $request["shop_id"];

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'username',
            'email',
            'password',
            'shop_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }

        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";

            $user_data = null;
            $data = [
                'results' => [
                    'user_data' => null,
                    'user_id' => '',
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }

        $time = Carbon::now();
        $personal_array = array(
            'username' => $username,
            'email' => $email,
            'shop_id' => $shop_id,
            'password' => Hash::make($password),
            'encriptp' => ($password),
            'time' => $time
        );

        $result = DB::table('users')->where('email', $email)->first();

        if (!empty($result)) {
            $code = 403;
            $message = "Your email address was registered already.";
            $user_id = "";
            $user_data = null;

        }  else {
            $code = 0;
            DB::table('users')->insert($personal_array);
            $user_data = DB::table('users')->where('email', $email)->first();
            $message = "Successfully Registered";
            $user_id = $user_data->id;

        }

        $data = [
            'results' => [
                'user_data' => $user_data,
            ],
            'error_code' => $code,
            'error_message' => $message
        ];

        return $data;
    }





    function signin(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        $fcm_token = $request['fcm_token'];

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }

        $column_arr = array(
            'email',
            'password'
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'user_data' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }

        $user = User::where('email', $email)
                ->where('encriptp', ($password))
                ->leftJoin('shop', 'shop.shop_id', '=', 'users.shop_id')
                ->first();
        

        if (!empty($user)) {
            $last_invoice = Transaction::where('shop_id', $user->shop_id)->max('invoice');

            $user['last_invoice']=$last_invoice;  //temparary

            User::where('email', $email)->update(['fcm_token' => $fcm_token]);
            $code = 0;
            $message = '';
        } else {
            $user = null;
            $message = 'Email or Password is wrong';
            $code = 403;
        }

        $data = [
            'results' => [
                'user_data' => $user,
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }






    public function forgotPassword(Request $request){
        $email = $request['email'];
        $to = $email;
        $subject = "Forgot Password For Texeer";
        $headers = "From: no-reply@texeer.com" . "\r\n" .
            "CC: jonmr0727222@gmail.com";

        $txt = "link for reset password: "."http://phrt.com.au/texeer/forgot_password?email=".$email;

        $r = mail($to, $subject, $txt, $headers);
        if ($r){
            $code = 0;
            $message = "";
        }else{
            $code = 403;
            $message = "Server error!";
        }

        $data = [
            'results' => [
                'forgot_password' => '',
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }




    public function emailverify(Request $request)
    {
        $email = $request['email'];
        $veryfiycode = rand(1000, 9999);
        $veryfiycode = "$veryfiycode";
        $to = $email;
        $subject = "verify email";
        $txt = "verify Code: " . $veryfiycode;
        $headers = "From: no-reply@heavykiwi.com" . "\r\n" .
            "CC: jonmr0727222@gmail.com";

        $r = mail($to, $subject, $txt, $headers);
        if ($r){
            $code = 0;
            $message = "";
        }else{
            $code = 403;
            $message = "Server error!";
        }

        $data = [
            'results' => [
                'verification_code' => $veryfiycode,
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }



    public function getMachines(Request $request){
        $pageNum = $request->pageNum;
        $searchKey = $request->searchKey;

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            //'user_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => null,
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }


        $users = Machine::getMachines($pageNum, $searchKey);
        $code = 0;
        $message = '';


        $data = [
            'results' => $users,
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }


    public function sendNotificationToAll(Request $request){
        $notification = new SendNotificationController();
        $notification->sendNotificationByFcm('title', 'subtitle');
    }









    public function getListTatble(Request $request){
        $shop_id = $request["shop_id"];
        
        $data = Table::where('shop_id', $shop_id)->get();
        $categories = Category::where('shop_id', $shop_id)->get();
        $taxs=Tax::where('shop_id', $shop_id)->get();
        $services=Service::get();
        $discount=Discount::get();
        $json_data['tables'] = $data;
        $json_data['categories'] = $categories;
        $json_data['taxs'] = $taxs;
        $json_data['services'] = $services;
        $json_data['discounts'] = $discount;
        $code = 0;
        $message = '';

        $data = [
            'results' => $json_data,
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }




    public function getProducts(Request $request){

        $shop_id = $request["shop_id"];
        $product_id = $request['category_id'];


        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'category_id',
            'shop_id'
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'products' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }

        $data = Product::where('category_id', $product_id)->where('shop_id', $shop_id)->get();

        $json_data['products'] = $data;
        $code = 0;
        $message = '';

        $data = [
            'results' => $json_data,
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }





    public function posttransaction(Request $request){

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(

        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'transaction' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }


        try{
            $transactions = $request['transactions'];

            $transaction_time = Carbon::now();

            foreach ($transactions as $item){
                Transaction::insert(["date_transaction"=>$transaction_time,"product_id"=>$item["product_id"],
                    "shop_id"=>$item['shop_id'],"status"=>$item['status'],
                    "table_id"=>$item['table_id'],"tax_amount"=>$item['tax_amount'],"total_amount"=>$item['total_amount'],
                    "transaction_id"=>$item['transaction_id'],"unit_price"=>$item['unit_price']]);
            }

            $error_code = 0;
            $error_message = "";

        }catch (\Exception $exception){
            $error_code = 403;
            $error_message = $exception->getMessage();
        }


        $data = [
            'results' => [
                'transaction' => null
            ],
            'error_code' => $error_code,
            'error_message' => $error_message
        ];
        return $data;
    }





    function addOrder(Request $request){

        $table_id = $request['table_id'];
        $product_name = $request['product_name'];
        $product_id = $request['product_id'];
        $shop_id = $request['shop_id'];
        $status = $request['status'];
        $unit_price = $request['unit_price'];
        $tax_amount = $request['tax_amount'];
        $total_amount = $request['total_amount'];
        //$last_invoice=$request['last_invoice'];


        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'table_id',
            'product_name',
            'product_id',
            'shop_id',
            'status',
            'unit_price',
            'tax_amount',
            'total_amount',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'transactions' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }


        try{
            $isExist = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>','BILLED')->exists();

            if ($isExist){
                $transaction = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status','<>', 'BILLED')->first();

                $date_transaction = $transaction->date_transaction;
                $invoice=$transaction->invoice;
                Transaction::insert(["date_transaction"=>$date_transaction,"invoice"=>$invoice,"product_id"=>$product_id, "shop_id"=>$shop_id,"status"=>$status,
                    "table_id"=>$table_id,"tax_amount"=>$tax_amount,"total_amount"=>$total_amount, "unit_price"=>$unit_price]);
            } else {
                $date_transaction = Carbon::now();
                $todaycode=date_format($date_transaction,"Ymd");
                $invoice=strval($todaycode) . "00001";

                //file_put_contents("log.txt",$todaycode);

                $last_invoice = Transaction::where('shop_id', $shop_id)->max('invoice');
                if($last_invoice){
                    $datecode=substr($last_invoice,0,8);
                    $numbercode=substr($last_invoice,8,5);
                    if($todaycode==$datecode){
                        $num=intval($numbercode)+1;
                        $newNumbercode=sprintf("%05d", $num);

                        $invoice=$datecode . $newNumbercode;
                    }
                }

                Transaction::insert(["date_transaction"=>$date_transaction,"invoice"=>$invoice,"product_id"=>$product_id, "shop_id"=>$shop_id,"status"=>$status,
                    "table_id"=>$table_id,"tax_amount"=>$tax_amount,"total_amount"=>$total_amount, "unit_price"=>$unit_price]);
            }

            $transactions = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->orderBy('transaction_id', 'desc')->get();


            foreach ($transactions as $item){
                $item['product_name'] = Product::where('product_id', $item->product_id)->where('shop_id', $shop_id)->first()->product_name;
            }

            $price = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('unit_price');
            $vat = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('tax_amount');
            $total = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('total_amount');

            $code = 0;
            $message = "";

        }catch (\Exception $exception){
            $transactions = null;
            $code = 403;
            $message = $exception->getMessage();

            $price = 0;
            $vat = 0;
            $total = 0;

        }


        $data = [
            'results' => [
                'transactions' => $transactions,
                'price' => round($price, 2),
                'vat' => round($vat, 2),
                'total'=>round($total, 2)
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }




    public function getOrdersFromTable(Request $request){
        $table_id = $request['table_id'];
        $shop_id = $request['shop_id'];

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'table_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'transactions' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }

        try{
            $transactions = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->orderBy('transaction_id', 'desc')->get();

            foreach ($transactions as $item){
                $item['product_name'] = Product::where('product_id', $item->product_id)->first()->product_name;
            }

            $price = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('unit_price');
            $vat = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('tax_amount');
            $total = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('total_amount');

            $code = 0;
            $message = '';

        } catch (\Exception $exception){
            $code = 403;
            $message = $exception->getMessage();
            $transactions = null;
            $price = 0;
            $vat = 0;
            $total = 0;
        }

        $data = [
            'results' => [
                'transactions' => $transactions,
                'price' => round($price, 2),
                'vat' => round($vat, 2),
                'total' => round($total, 2)
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }


    public function getReport1FromTable(Request $request){
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $code = 0;
        $message = "";

        try{
            $datelist = DB::select("SELECT DISTINCT(SUBSTRING(date_transaction,1,10)) AS datelist FROM `transaction` ORDER BY date_transaction");
            $reportItems=array();

            foreach ($datelist as $row){
                $dateReport=array();
                //$item['product_name'] = Product::where('product_id', $item->product_id)->first()->product_name;
                $theDate=$row->datelist;
                if($theDate>=$start_date && $theDate<=$end_date ){
                    $productlist=DB::select("SELECT p.product_name,p.product_description, COUNT(*) as quantity, SUM(total_amount) as price FROM `transaction` t JOIN `product` p ON p.product_id=t.product_id  WHERE date_transaction LIKE '%$theDate%'  GROUP BY t.product_id");
                    $total=DB::select("SELECT SUM(total_amount) as total FROM `transaction` WHERE date_transaction LIKE '%$theDate%'");

                    $dateReport["date"]=$theDate;
                    $dateReport["items"]=$productlist;
                    $dateReport["table_name"]="";
                    $dateReport["total"]=$total[0]->total;
                    array_push($reportItems,$dateReport);
                }
            }

        } catch (\Exception $exception){
            $code = 403;
            $message = $exception->getMessage();
            $reportItems = null;
            $price = 0;
            $vat = 0;
            $total = 0;
        }

        $data = [
            'results' => [
                'reports' => $reportItems
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }

    public function getReport2FromTable(Request $request){
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $code = 0;
        $message = "";

        try{
            $timelist = DB::select("SELECT DISTINCT(date_transaction) AS thetime,table_id FROM `transaction` ORDER BY date_transaction");
            $reportItems=array();

            foreach ($timelist as $row){
                $dateReport=array();
                //$item['product_name'] = Product::where('product_id', $item->product_id)->first()->product_name;
                $theTime=$row->thetime;
                $theDate=substr($theTime,0,10);
                if($theDate>=$start_date && $theDate<=$end_date ){
                    $table_id=$row->table_id;
                    $table_name=Table::where('table_id',$table_id)->first()->table_name;

                    $productlist=DB::select("SELECT p.product_name,p.product_description, COUNT(*) as quantity, SUM(total_amount) as price FROM `transaction` t JOIN `product` p ON p.product_id=t.product_id  WHERE date_transaction='$theTime'  GROUP BY t.product_id");
                    $total=DB::select("SELECT SUM(total_amount) as total FROM `transaction` WHERE date_transaction='$theTime'");

                    $dateReport["date"]=$theTime;
                    $dateReport["items"]=$productlist;
                    $dateReport["table_name"]=$table_name;
                    $dateReport["total"]=$total[0]->total;
                    array_push($reportItems,$dateReport);
                }
            }

        } catch (\Exception $exception){
            $code = 403;
            $message = $exception->getMessage();
            $reportItems = null;
            $price = 0;
            $vat = 0;
            $total = 0;
        }

        $data = [
            'results' => [
                'reports' => $reportItems
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }

    public function deleteOrderItem(Request $request){
        $table_id = $request['table_id'];
        $product_id = $request['product_id'];
        $shop_id = $request['shop_id'];
        $status = "Open";
        $transaction_id = $request['transaction_id'];

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'table_id',
            'product_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'transactions' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }

        try{
            Transaction::where('transaction_id', $transaction_id)->where('table_id', $table_id)->where('shop_id', $shop_id)->where('product_id', $product_id)->where(function ($query) {$query->where('status', "Open")->orWhere('status', "Cancel");})->delete();
            $transactions = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->orderBy('transaction_id', 'desc')->get();
            foreach ($transactions as $item){
                $item['product_name'] = Product::where('product_id', $item->product_id)->first()->product_name;
            }

            $price = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('unit_price');
            $vat = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('tax_amount');
            $total = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('total_amount');

            $code = 0;
            $message = '';
        } catch (\Exception $exception){
            $code = 403;
            $message = $exception->getMessage();
            $transactions = null;

            $price = 0;
            $vat = 0;
            $total = 0;
        }
        $data = [
            'results' => [
                'transactions' => $transactions,
                'price' => round($price, 2),
                'vat' => round($vat, 2),
                'total' => round($total, 2)
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;

    }

public function changeOrderItem(Request $request){
        $table_id = $request['table_id'];
        $product_id = $request['product_id'];
        $shop_id = $request['shop_id'];
		$new_price=$request['price'];
		$new_vatprice=$request['vat_price'];
        $status = "Open";
        $transaction_id = $request['transaction_id'];


        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'table_id',
            'product_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
				return $val;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'transactions' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }

        try{
			
			$res=DB::table("transaction")->where('transaction_id','=',$transaction_id)->where('table_id','=',$table_id)->where('shop_id','=',$shop_id)->where('product_id','=',$product_id)->first();
			$new_total=$new_price+$new_vatprice;
			
			//return $tax .' '.$new_total;
			
			DB::table("transaction")->where('transaction_id','=',$transaction_id)->where('table_id','=',$table_id)->where('shop_id','=',$shop_id)->where('product_id','=',$product_id)->update(['unit_price'=>$new_price,'tax_amount'=>$new_vatprice,'total_amount'=>$new_total]);
			
			
            $transactions = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->orderBy('transaction_id', 'desc')->get();
            foreach ($transactions as $item){
                $item['product_name'] = Product::where('product_id', $item->product_id)->first()->product_name;
            }

            $price = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('unit_price');
            $vat = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('tax_amount');
            $total = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', '<>', 'BILLED')->where('status', '<>', "Cancel")->sum('total_amount');

            $code = 0;
            $message = '';
        } catch (\Exception $exception){
            $code = 403;
            $message = $exception->getMessage();
            $transactions = null;

            $price = 0;
            $vat = 0;
            $total = 0;
        }
        $data = [
            'results' => [
                'transactions' => $transactions,
                'price' => round($price, 2),
                'vat' => round($vat, 2),
                'total' => round($total, 2)
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;

    }










    public function bill(Request $request){
        $table_id = $request['table_id'];
        $status = "Served";
        $shop_id = $request['shop_id'];

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'table_id',
            'shop_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'transactions' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }

        try{
            $transactions = Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where(function ($query) use ($status){$query->where("status", $status)->orWhere('status', 'Open');})->get();
            foreach ($transactions as $item){
                $item['product_name'] = Product::where('product_id', $item->product_id)->first()->product_name;
            }
            //Transaction::where('table_id', $table_id)->where('status', $status)->update(['status'=>'BILLED']);
            $code = 0;
            $message = '';
        } catch (\Exception $exception){
            $code = 403;
            $message = $exception->getMessage();
            $transactions = null;
        }
        $data = [
            'results' => [
                'transactions' => $transactions
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;

    }



    function complete(Request $request){
        $table_id = $request['table_id'];
        $status = "Served";
        $shop_id = $request['shop_id'];

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'table_id',
            'shop_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'transactions' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }

        try{
            Transaction::where('table_id', $table_id)->where('shop_id', $shop_id)->where('status', $status)->update(['status'=>'BILLED']);
            $code = 0;
            $message = '';
            $transactions = null;
        } catch (\Exception $exception){
            $code = 403;
            $message = $exception->getMessage();
            $transactions = null;
        }
        $data = [
            'results' => [
                'transactions' => $transactions
            ],
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;

    }




















    // kitchen

    public function getTatbles(Request $request){


        $pageNum = $request->pageNum;
        $searchKey = $request->searchKey;
        $shop_id = $request['shop_id'];

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array();

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'visitors' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }


        $users = Transaction::getTables($shop_id, $pageNum, $searchKey);
        $code = 0;
        $message = '';


        $data = [
            'results' => $users,
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }





    public function getspecifiedtabletransactions(Request $request){
        $table_id = $request['table_id'];
        $date_transaction = $request['date_transaction'];
        $shop_id = $request['shop_id'];


        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'table_id',
            'date_transaction',
            'shop_id'
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'visitors' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }


        $transactions = Transaction::where('table_id', $table_id)->where('transaction.shop_id', $shop_id)->where('date_transaction', $date_transaction) ->leftJoin('product', 'product.product_id', '=', 'transaction.product_id')->get();


        $data = [
            'results' => [
                "transactions" => $transactions
            ],
            'error_code' => 0,
            'error_message' => ""
        ];
        return $data;

    }








    public function setStatus(Request $request){
        $transaction_id = $request['transaction_id'];
        $table_id = $request['table_id'];
        $date_transaction = $request['date_transaction'];
        $product_id = $request['product_id'];
        $status = $request["status"];


        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'transaction_id',
            'table_id',
            'date_transaction',
            'product_id',
            'status',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'visitors' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }


        try{
            Transaction::where('transaction_id', $transaction_id)->where('table_id', $table_id)->where('date_transaction', $date_transaction)->where('product_id', $product_id)->update(['status' => $status]);
            $transaction = Transaction::where('transaction_id', $transaction_id)->where('table_id', $table_id)->where('date_transaction', $date_transaction)->where('product_id', $product_id)->first();
            $error_message = "";
            $error_code = 0;
        }catch (\Exception $exception){
            $error_message = $exception->getMessage();
            $transaction = null;
            $error_code = 403;
        }



        $data = [
            'results' => [
                "transaction" => $transaction
            ],
            'error_code' => $error_code,
            'error_message' => $error_message
        ];
        return $data;
    }

























    public function getUsers(Request $request){
        $me_id = $request->user_id;
        $pageNum = $request->pageNum;
        $searchKey = $request->searchKey;


        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'user_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'visitors' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }


        $users = User::getUsers($me_id, $pageNum, $searchKey);
        $code = 0;
        $message = '';


        $data = [
            'results' => $users,
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;
    }


    public function changeProfile(Request $request){
        $me_id = $request['me_id'];
        $user_pic = $request->file('avatar');
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $birthday = $request['birthday'];
        $gender = $request['gender'];  // 0 => male, 1 => female



        if ($user_pic){
            $new_name = time().'.'.$user_pic->getClientOriginalExtension();
            $origin_name = $user_pic->getClientOriginalName();
            $destinationPath = public_path('/uploads/images/users');
            //$picProfile = '/public/uploads/images/users/'.$new_name;
            $picProfile = $new_name;
            $user_pic->move($destinationPath, $new_name);

        }else{
            $picProfile = null;
        }


        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }

        $column_arr = array(
            'firstname',
            'lastname',
            'birthday',
            'gender',
            'me_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }

        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";

            $user_data = null;
            $data = [
                'results' => [
                    'user_data' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }



        if ($picProfile != null){
            $personal_array = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'birthday' => $birthday,
                'gender' => $gender,
                'avatar' => $picProfile,
            );
        } else {
            $personal_array = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'birthday' => $birthday,
                'gender' => $gender,
            );
        }


        try{
            DB::table('users')->where('id', $me_id)->update($personal_array);
            $user_data = DB::table('users')->where('id', $me_id)->first();
            $code = 0;
            $message = '';
        }catch (\Exception $exception){
            $user_data = DB::table('users')->where('id', $me_id)->first();
            $code = 403;
            $message = $exception->getMessage();

        }

        $data = [
            'results' => [
                'user_data' => $user_data,
            ],
            'error_code' => $code,
            'error_message' => $message
        ];

        return $data;

    }




    public function getUserProfile(Request $request){
        $me_id = $request['me_id'];

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }

        $column_arr = array(
            'me_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }

        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";

            $user_data = null;
            $data = [
                'results' => [
                    'user_data' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }


        $user = User::find($me_id);
        if ($user){
            $user_data = $user;
            $code = 0;
            $message = '';
            $visitiorsCNT = Relation::getVisitorsCNT($user->id);
            $visitingsCNT = Relation::getVisitingsCNT($user->id);
        }else{
            $user_data = null;
            $visitiorsCNT = 0;
            $visitingsCNT = 0;
            $code = 403;
            $message = 'No User';
        }


        $data = [
            'results' => [
                'user_data' => $user_data,
                'visitiorsCNT' => $visitiorsCNT,
                'visitingsCNT' => $visitingsCNT
            ],
            'error_code' => $code,
            'error_message' => $message
        ];

        return $data;

    }




    public function getContacts(Request $request){

        $me_id = $request->me_id;
        $pageNum = $request->pageNum;
        $searchKey = $request->searchKey;

        $keys = array();
        foreach ($_POST as $key => $val) {
            $keys[] = $key;
        }
        $column_arr = array(
            'me_id',
        );

        $flag = 0;
        foreach ($column_arr as $val) {
            if (!in_array($val, $keys)) {
                $flag = 1;
                break;
            }
        }
        if ($flag == '1') {
            $code = 403;
            $message = "Please send " . $val . " parameter in post.";
            $user_data = null;
            $data = [
                'results' => [
                    'visitors' => null,
                ],
                'error_code' => $code,
                'error_message' => $message
            ];
            return $data;
        }



        try{
            $visitors = ChatContact::getContacts($me_id, $pageNum, $searchKey);
            $code = 0;
            $message = '';
        }catch (\Exception $exception){
            $visitors = null;
            $code = 403;
            $message = $exception->getMessage();
        }


        $data = [
            'results' => $visitors,
            'error_code' => $code,
            'error_message' => $message
        ];
        return $data;


    }

}
