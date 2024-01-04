<?php

use App\Events\ChannelPublic;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

 


// Route::get('/send',function(){

//     $response = Http::post('https://api.factplus.co.ao', [
//         'apicall' => 'SEND',
//         'apikey' => '65899c23c9b6e95943468c44c9ecd952',
//         'document'=>[
//             'reference'=>'1704294369',
//             'type'=>'factura',
//         ],
//         'recipient'=>[
//             'address'=>'pachecobarrosodig4@gmail.com',
//             'subject'=>'FACTURA DE PAGAMENTO',
//             'message'=>'SUA FACTURA DE PAGAMENTO, RESTAURANTE KARAMBA',
//             'copy'=>'0',
//         ]
//     ]);


//     dd($response['data']);
// });
// Route::get('/alter',function(){

//     $response = Http::post('https://api.factplus.co.ao', [
//         'apicall' => 'ALTER',
//         'apikey' => '65899c23c9b6e95943468c44c9ecd952',
//         'document'=>[
//             'type'=>'factura',
//             'reference'=>'1704357099',
//             'status'=>'sent',
//             'reason'=>'',
//         ]
//     ]);


//     dd($response['result']);
// });
// Route::get('/create',function(){


    

//     $response = Http::post('https://api.factplus.co.ao', [
//         'apicall' => 'CREATE',
//         'apikey' => '65899c23c9b6e95943468c44c9ecd952',
//         'document'=>[
//             'type'=>'factura',
//             'date'=>'2024-01-04',
//             'duedate'=>'2024-01-10',
//             'vref'=>'settled',
//             'serie'=>'2024',
//             'currency'=>'AOA',
//             'exchange_rate'=>'0',
//             'observation'=>'FActura de Pagamento',
//             'retention'=>'',
//         ],
//         'client'=>[
//             'name'=>'CONSUMIDOR FINAL',
//             'nif'=>'99999999',
//             'email'=>'test@gmail.com',
//             'city'=>'Luanda',
//             'address'=>'Luanda-Angola',
//             'postalcode'=>'',
//             'country'=>'Angola',
//         ],
//         'items'=>[
//             [
//             'itemcode'=>'WEB001',
//             'description'=>'Website',
//             'price'=>'200000',
//             'quantity'=>'2',
//             'tax'=>'0%',
//             'discount'=>'0',
//             'exemption_code'=>'M11',
//             'retention'=>'',
//             ]
//         ]
//     ]);


//     dd($response['message']);
// });

require __DIR__ .'/admin/routes.php';
require __DIR__ .'/chef/routes.php';
require __DIR__ .'/room_manager/routes.php';
require __DIR__ .'/client/routes.php';
require __DIR__ .'/garçon/routes.php';
require __DIR__ .'/auth/routes.php';
require __DIR__ .'/site/routes.php';
require __DIR__ .'/restaurant/routes.php';
require __DIR__ .'/control/routes.php';
require __DIR__ .'/economate/routes.php';
require __DIR__ .'/treasury/routes.php';
require __DIR__ .'/barman/routes.php';


