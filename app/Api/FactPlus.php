<?php

namespace App\Api;

use App\Models\DetailOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;




class FactPlus {

 

 
    public static function create($orderid)
    {
        DB::beginTransaction();
        //real
        $key = '65847d93edbb6d77bea624101ff616ea';
        //teste
        //$key = '65995993b16b93cdac74e28f1cd69267';
        try {

           $details =  DetailOrder::where('order_id','=',$orderid)
           ->select('id','item','price','quantity')
           ->get();
           $date = date('Y-m-d');
           $duedate = date('Y-m-d',strtotime('+7 days'));
           $vref = rand(10000,20000);
           $serie = date('Y');
           $insert = [];
          

            foreach ($details as  $item) {
                if ($item->tax == 0) {
                    array_push($insert,[
                    "itemcode"=> $item->id,
                    "description"=> $item->item,
                    "price"=> $item->price,
                    "quantity"=> $item->quantity,
                    "tax"=> "0",
                    "discount"=> "0",
                    "exemption_code"=> "M10",
                    "retention"=> ""
                    ]);
                } else {
                    array_push($insert,[
                        "itemcode"=> $item->id,
                        "description"=> $item->item,
                        "price"=> $item->price,
                        "quantity"=> $item->quantity,
                        "tax"=> $item->tax,
                        "discount"=> "0",
                        "exemption_code"=> "",
                        "retention"=> ""
                        ]);
                }
                
            }


            //Chamada a API do Factplus

            $response = Http::post('https://api.factplus.co.ao', [
                'apicall' => 'CREATE',
                'apikey' => $key,
                'document'=>[
                    'type'=>'factura',
                    'date'=>$date,
                    'duedate'=>$duedate,
                    'vref'=>$vref,
                    'serie'=>$serie,
                    'currency'=>'AOA',
                    'exchange_rate'=>'0',
                    'observation'=>'Factura de Pagamento',
                    'retention'=>'',
                ],
                'client'=>[
                    'name'=>'CONSUMIDOR FINAL',
                    'nif'=>'99999999',
                    'email'=>'',
                    'city'=>'Luanda',
                    'address'=>'Luanda-Angola',
                    'postalcode'=>'',
                    'country'=>'Angola',
                ],
                'items'=>$insert
            ]);

            $collection  = json_decode($response,true);

            return $collection->data;
           
    
          DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error','Falha ao realizar Operação');
        }
    }

    public static function sendInvoice($reference,$email)
    {
        DB::beginTransaction();
        //real
        $key = '65847d93edbb6d77bea624101ff616ea';
        //teste
        //$key = '65995993b16b93cdac74e28f1cd69267';
        try {
            $response = Http::post('https://api.factplus.co.ao', [
                'apicall' => 'SEND',
                'apikey' => $key,
                'document'=>[
                    'reference'=>$reference,
                    'type'=>'factura',
                ],
                'recipient'=>[
                    'address'=>$email,
                    'subject'=>'FACTURA DE PAGAMENTO',
                    'message'=>'SUA FACTURA DE PAGAMENTO, RESTAURANTE KARAMBA',
                    'copy'=>'0',
                ]
            ]);

          return $response['result'];
          DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error','Falha ao realizar Operação');
        }
    }


    public static function changeStatu($reference)
    {
        DB::beginTransaction();
         //real
        $key = '65847d93edbb6d77bea624101ff616ea';
        //teste
        //$key = '65995993b16b93cdac74e28f1cd69267';
        try {
            $response = Http::post('https://api.factplus.co.ao', [
                'apicall' => 'ALTER',
                'apikey' =>  $key,
                'document'=>[
                    'type'=>'factura',
                    'reference'=>$reference,
                    'status'=>'sent',
                    'reason'=>'',
                ]
            ]);

          return  $response['result'];

          DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error','Falha ao realizar Operação');
        }
    }
}