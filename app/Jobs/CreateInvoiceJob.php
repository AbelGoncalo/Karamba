<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
     private $orderid;
    public function __construct($orderid)
    {
        $this->orderid = $orderid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
              
                $reference = \App\Api\FactPlus::create($this->orderid);

                session()->put('finallyOrder',$reference);
    }
}
