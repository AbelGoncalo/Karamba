<?php

namespace App\Api;

use App\Models\DetailOrder;

class FactPlus{
    public static function create($orderid)
    {
        try {

           $details =  DetailOrder::where('order_id','=',$orderid)->get();
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

            $col = json_encode($insert);


            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.factplus.co.ao",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\r\n      \"apicall\":\"CREATE\",\r\n      \"apikey\": \"65899c23c9b6e95943468c44c9ecd952\",\r\n      \"document\": {\r\n        \"type\": \"factura\",\r\n        \"date\": \"$date\",\r\n        \"duedate\": \"$duedate\",\r\n        \"vref\": \"$vref\",\r\n        \"serie\":\"$serie\",\r\n        \"currency\":\"AOA\",\r\n        \"exchange_rate\":\"0\",\r\n        \"observation\":\"Factura de Pagamento\",\r\n        \"retention\":\"\"\r\n        },\r\n      \"client\":{\r\n        \"name\": \"Consumidor Final\",\r\n        \"nif\": \"999999999\",\r\n        \"email\": \"consumidor@gmail.com\",\r\n        \"city\": \"Luanda\",\r\n        \"address\":\"Luanda,Angola\",\r\n        \"postalcode\":\"\",\r\n        \"country\":\"Angola\"\r\n      },\r\n       \"items\": $col\r\n    }",
            CURLOPT_HTTPHEADER => array(
              "Content-Type: application/json"
            ),
          ));
      
          $response = curl_exec($curl);
      
          curl_close($curl);
      
      
          $collection = collect(json_decode($response,true));

          return $collection['data'];
           
    
         
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');
        }
    }


    public static function Show($reference)
    {
        try {
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
                    CURLOPT_POSTFIELDS =>"{\r\n    \"apicall\" : \"VIEW\",\r\n    \"apikey\" : \"65847d93edbb6d77bea624101ff616ea\",\r\n    \"document\" : {\r\n        \"reference\" : \"$reference\",\r\n        \"type\" : \"factura\"\r\n    }\r\n}   \r\n",
                    CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                    ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);

                    $collection = collect(json_decode($response));
                    //  dd($collection['data']);

                    return $collection['data'];
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');
        }
    }


    public static function sendInvoice($reference,$email)
    {
        try {
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
              CURLOPT_POSTFIELDS =>"{\r\n      \"apicall\":\"SEND\",\r\n      \"apikey\": \"65899c23c9b6e95943468c44c9ecd952\",\r\n      \"document\": {\r\n        \"reference\": \"$reference\",\r\n        \"type\": \"factura\"\r\n  }, \"recipient\": {\r\n        \"address\": \"$email\",\r\n        \"subject\": \"Pagamento da Factura\",\r\n \"message\": \"caríssimo(s), Em anexo a sua factura ( RESTAURANTE KARAMBA)\",\r\n \"copy\": \"0\"\r\n  }   }",
              CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
              ),
            ));
          
            $response = curl_exec($curl);
            
            curl_close($curl);
            
            
            $collection = json_decode($response,true);

          return $collection['data'];
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');
        }
    }
    public static function changeStatu($reference)
    {
        try {
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
                CURLOPT_POSTFIELDS =>"{\r\n      \"apicall\":\"ALTER\",\r\n      \"apikey\": \"65899c23c9b6e95943468c44c9ecd952\",\r\n      \"document\": {\r\n        \"reference\": \"$reference\",\r\n        \"type\": \"factura\",\r\n \"status\": \"settled\",\r\n \"reason\": \"\"\r\n   }   }",
                CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);


                $collection = json_decode($response,true);

          return $collection['data'];
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');
        }
    }
}