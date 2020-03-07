<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Table;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CachierController extends Controller
{


    function index(Request $request){
        $tables = Table::get();
        $categories = Category::get();


        return view('cashier', ['categories' => $categories, 'tables' => $tables]);
    }



    function getProducts(Request $request){
        $category_id = $request['category_id'];
        $products = Product::where('category_id', $category_id)->get();
        $data = [
            'results' => $products,
            'error_code' => 0,
            'error_message' => ''
        ];
        return $data;
    }


    function submit(Request $request){
        $tax = 6 / 100;

        $time_now = Carbon::now();
        $date_transaction = $time_now;
        $tableId = $request->tableId;
        $productId = $request->productId;
        $unitPrice = $request->unitPrice;
        $taxAmount = $unitPrice * $tax;
        $totalAmount = $unitPrice + $taxAmount;
        $status = "In Progress";
        $shopId = $request->shopId;

        $results = Transaction::insert(['date_transaction'=>$date_transaction, 'table_id'=>$tableId,
            'product_id'=>$productId, 'unit_price'=>$unitPrice, 'tax_amount'=>$taxAmount,
            'total_amount'=>$totalAmount, 'status'=>$status, 'shop_id'=>$shopId]);

        $data = [
            'results' => $results,
            'error_code' => 0,
            'error_message' => ''
        ];
        return $data;

    }



    function getOrders(Request $request){
        $columns = array(
            5 => 'transaction_id',
            0 =>'table_id',
            1=> 'product_id',
            2=> 'tax_amount',
            3 => 'date_transaction',
            4=> 'total_amount',
            8=> 'unit_price',
            6 => 'status',
            7 => 'shop_id',


        );

        $tableId = $request['tableId'];
        $totalData = Transaction::where('table_id', $tableId)->count();
        $totalFiltered = $totalData;



        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $users = Transaction::offset($start)
                ->where('table_id', $tableId)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }
        else {
            $search = $request->input('search.value');

            $users =  Transaction::where('shop_id','LIKE',"%{$search}%")
                ->where('table_id', $tableId)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = count($users);
        }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $item)
            {
                $product_name = Product::where('product_id', $item->product_id)->first()->product_name;
                $nestedData['product_name'] = $product_name;
                $nestedData['status'] = $item->status;
                $nestedData['shop_id'] = $item->shop_id;
                $nestedData['date_transaction'] = $item->date_transaction;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data, 200);

    }



    function getBillPrice(Request $request){
        $tableId = $request['tableId'];
        $totalPrice = Transaction::where('table_id', $tableId)->sum('total_amount');

        $data = [
            'results' => round($totalPrice, 2),
            'error_code' => 0,
            'error_message' => ''
        ];
        return $data;

    }



}
