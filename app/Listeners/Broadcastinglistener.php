<?php

namespace App\Listeners;

use App\Events\BroadcastingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class Broadcastinglistener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BroadcastingEvent $event): void
    {
       Cache::put('broadcasting', [
        'data'=>$event->data
       ],now()->addMinutes(5));
    }
}
