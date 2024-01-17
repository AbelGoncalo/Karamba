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
         $key = '65a676382d20f38a75ff2829c0b2a89a';
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
               
                     array_push($insert,[
                     "itemcode"=> $item->id,
                     "description"=> \App\Services\Replace::newString($item->item),
                     "price"=> $item->price,
                     "quantity"=> $item->quantity,
                     "tax"=> "0",
                     "discount"=> "0",
                     "exemption_code"=> "M10",
                     "retention"=> ""
                     ]);
                 
                
              }

              
      
        


        
         $data =  json_encode($insert);
       
       //     //Chamada a API do Factplus

       $data = array_map(function ($item) {
                 return array_map('utf8_encode', $item);
            }, $insert);

            $json = json_encode($data);
             

         $curl = curl_init();
         curl_setopt_array($curl, array(
           CURLOPT_URL => "https://api.factplus.co.ao",
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => "",
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => "POST",
           CURLOPT_POSTFIELDS =>"{\r\n      \"apicall\":\"CREATE\",\r\n      \"apikey\": \"$key\",\r\n      \"document\": {\r\n        \"type\": \"factura\",\r\n        \"date\": \"$date\",\r\n        \"duedate\": \"$duedate\",\r\n        \"vref\": \"$vref\",\r\n        \"serie\":\"$serie\",\r\n        \"currency\":\"AOA\",\r\n        \"exchange_rate\":\"0\",\r\n        \"observation\":\"Factura de Consumo no Kytutes\",\r\n        \"retention\":\"0\"\r\n        },\r\n      \"client\":{\r\n        \"name\": \"$name\",\r\n        \"nif\": \"$nif\",\r\n        \"email\": \"\",\r\n        \"city\": \"Luanda\",\r\n        \"address\":\"$address\",\r\n        \"postalcode\":\"\",\r\n        \"country\":\"Angola\"\r\n      },\r\n       \"items\": $json\r\n    }",
           CURLOPT_HTTPHEADER => array(
             "Content-Type: application/json"
           ),
         ));
         
         $response = curl_exec($curl);
         
         curl_close($curl);
         $result = collect(json_decode($response));
        
        return $result['data'];
    
    


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
        $key = '65a676382d20f38a75ff2829c0b2a89a';
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
        $key = '65a676382d20f38a75ff2829c0b2a89a';
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