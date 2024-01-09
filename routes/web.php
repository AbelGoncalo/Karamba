<?php

use App\Events\ChannelPublic;
use App\Events\NotifyEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Laravel\SerializableClosure\SerializableClosure;



Route::get('/test',function(){
   $new  = \App\Services\Replace::newString('António José Miguel');
   dd($new);
});

 

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




