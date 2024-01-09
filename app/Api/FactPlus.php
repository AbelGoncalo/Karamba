<?php

namespace App\Api;

use App\Models\DetailOrder;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;




class FactPlus {

 

 
    public static function create($orderid,$name,$nif,$address)
    {
       
        // DB::beginTransaction();
        // //real
        //$key = '65847d93edbb6d77bea624101ff616ea';
        // //teste
         $key = '659bd7b97df70045df81c481d1813746';
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
                     "description"=> \App\Services\Replace::newString($item->item),
                     "price"=> $item->price,
                     "quantity"=> $item->quantity,
                     "tax"=> "0",
                     "discount"=> "0",
                     "exemption_code"=> "M11",
                     "retention"=> ""
                     ]);
                 } else {
                     array_push($insert,[
                         "itemcode"=> $item->id,
                         "description"=> \App\Services\Replace::newString($item->item),
                         "price"=> $item->price,
                         "quantity"=> $item->quantity,
                         "tax"=> $item->tax,
                         "discount"=> "0",
                         "exemption_code"=> "",
                         "retention"=> ""
                         ]);
                 }
                
              }

              
           

        


        
         $data =  json_encode($insert);
       
       //     //Chamada a API do Factplus

       $data = array_map(function ($item) {
                 return array_map('utf8_encode', $item);
            }, $insert);

            $json = json_encode($data);
            

         $response = Http::post('https://api.factplus.co.ao', [
             'apicall' => 'CREATE',
             'apikey' => $key,
             'Content-Type' => 'application/json; charset=utf-8',
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
                 'name'=>$name ?? 'CONSUMIDOR FINAL',
                 'nif'=>$nif ?? '99999999',
                 'email'=>'',
                 'city'=>'Luanda',
                 'address'=>$address,
                 'postalcode'=>'',
                 'country'=>'Angola',
             ],
             'items'=> $json
         ])->timeout(1200);

        return $response['data'];
    
    


    }catch(Exception $th){

       
        return "Api Indisponível";
        
    }
      
    }

    public static function sendInvoice($reference,$email)
    {
        DB::beginTransaction();
        //real
        //$key = '65847d93edbb6d77bea624101ff616ea';
        //teste
        $key = '659bd7b97df70045df81c481d1813746';
        try {
            $response = Http::post('https://api.factplus.co.ao','utf8_encode', [
                'apicall' => 'SEND',
                'apikey' => $key,
                'Content-Type' => 'application/json; charset=utf-8',
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


    public static function changeStatu($reference,$statu)
    {
        DB::beginTransaction();
         //real
        //$key = '65847d93edbb6d77bea624101ff616ea';
        //teste
        $key = '65995993b16b93cdac74e28f1cd69267';
        try {
            $response = Http::post('https://api.factplus.co.ao','utf8_encode', [
                'apicall' => 'ALTER',
                'apikey' =>  $key,
                'Content-Type' => 'application/json; charset=utf-8',
                'document'=>[
                    'type'=>'factura',
                    'reference'=>$reference,
                    'status'=>$statu,
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