<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transaction";
    protected $fillable = [
        'transaction_id', 'date_transaction','invoice', 'table_id', 'product_id', 'unit_price', 'tax_amount', 'total_amount', 'status', 'shop_id',
    ];
    public $timestamps = false;





    public static function getTables($shop_id ,$pageNum, $searchKey){
        $limit = 10;
        $start = ($pageNum - 1) * $limit;

        $order = 'date_transaction';
        $dir = 'desc';

        $totalData = Transaction::select(['date_transaction', 'table_id'])->where('shop_id', $shop_id)->distinct()->get();
        $totalFiltered = count($totalData);

        if(empty($searchKey))
        {
            $users = Transaction::select(['date_transaction', 'table_id'])->where('shop_id', $shop_id)->distinct()->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $searchKey;
            $users =  Transaction::select(['date_transaction', 'table_id'])->where('shop_id', $shop_id)->distinct()->where('table_id','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
            $totalFiltered =  count(Transaction::select(['date_transaction', 'table_id'])->where('shop_id', $shop_id)->distinct()->where('table_id','LIKE',"%{$search}%")->get());
        }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $item)
            {
                $nestedData['table_id'] = $item->table_id;
                $table_name = Table::where('table_id', $item->table_id)->first()->table_name;
                $nestedData['table_name'] = $table_name;
                $nestedData['date_transaction'] = $item->date_transaction;

                $nestedData['transactions'] = Transaction::where('date_transaction', $item->date_transaction)
                    ->where('transaction.shop_id', $shop_id)
                    ->where('table_id', $item->table_id)
                    ->leftJoin('product', 'product.product_id', '=', 'transaction.product_id')->get();

                $data[] = $nestedData;
            }
        }

        $totalPage =  ceil($totalFiltered / $limit);
        $json_data['tables'] = $data;
        $json_data["totalPage"] = $totalPage;
        return $json_data;
    }


}
