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
        // //$key = '65847d93edbb6d77bea624101ff616ea';
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

              
           

        


        
    //     $data =  json_encode($insert);
       

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //     CURLOPT_URL => "https://api.factplus.co.ao",
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 460,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => "POST",
    //     CURLOPT_POSTFIELDS =>"{\r\n      \"apicall\":\"CREATE\",\r\n      \"apikey\": \"659bd7b97df70045df81c481d1813746\",\r\n      \"document\": {\r\n        \"type\": \"factura\",\r\n        \"date\": \"$date\",\r\n        \"duedate\": \"$duedate\",\r\n        \"vref\": \"$vref\",\r\n        \"serie\":\"$serie\",\r\n        \"currency\":\"AOA\",\r\n        \"exchange_rate\":\"0\",\r\n        \"observation\":\"Factura de Pagamento\",\r\n        \"retention\":\"\"\r\n        },\r\n      \"client\":{\r\n        \"name\": \"$name\",\r\n        \"nif\": \"$nif\",\r\n        \"email\": \"consumidor@gmail.com\",\r\n        \"city\": \"Luanda\",\r\n        \"address\":\"$address\",\r\n        \"postalcode\":\"\",\r\n        \"country\":\"Angola\"\r\n      },\r\n       \"items\": $data\r\n    }",
    //     CURLOPT_HTTPHEADER => array(
    //       "Content-Type: application/json"
    //     ),
    //   ));
  
    //   $response = curl_exec($curl);
    //   dd($response);
    //   curl_close($curl);
    //   $value = json_decode($response);
    //   return $value->data;


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
    CURLOPT_POSTFIELDS =>"{\r\n      \"apicall\":\"CREATE\",\r\n      \"apikey\": \"659bd7b97df70045df81c481d1813746\",\r\n      \"document\": {\r\n        \"type\": \"factura\",\r\n        \"date\": \"2024-08-18\",\r\n        \"duedate\": \"2024-08-25\",\r\n        \"vref\": \"XPTO001\",\r\n        \"serie\":\"2020\",\r\n        \"currency\":\"AOA\",\r\n        \"exchange_rate\":\"0\",\r\n        \"observation\":\"Documento simples\",\r\n        \"retention\":\"6.5\"\r\n        },\r\n      \"client\":{\r\n        \"name\": \"john Doe\",\r\n        \"nif\": \"000000000\",\r\n        \"email\": \"cliente@gmail.com\",\r\n        \"city\": \"Luanda\",\r\n        \"address\":\"Av Fidel Castro\",\r\n        \"postalcode\":\"\",\r\n        \"country\":\"Angola\"\r\n      },\r\n       \"items\": [\r\n                {\r\n                    \"itemcode\": \"WEB001\",\r\n                    \"description\": \"Software\",\r\n                    \"price\": \"1000000\",\r\n                    \"quantity\": \"1\",\r\n                    \"tax\": \"14\",\r\n                    \"discount\": \"0\",\r\n                    \"exemption_code\": \"\",\r\n                    \"retention\": \"\"\r\n                },\r\n                {\r\n                    \"itemcode\": \"WEB001\",\r\n                    \"description\": \"Website\",\r\n                    \"price\": \"200000\",\r\n                    \"quantity\": \"2\",\r\n                    \"tax\": \"14\",\r\n                    \"discount\": \"0\",\r\n                    \"exemption_code\": \"\",\r\n                    \"retention\": \"\"\r\n                }\r\n               \r\n            ]\r\n    }",
    CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    
    if ($response == false) {
        throw new \Exception('Erro cURL: ' . curl_error($curl));
    } else {
        dd($response);
    }
    


    }catch(Exception $th){
        dd($th->getMessage());
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