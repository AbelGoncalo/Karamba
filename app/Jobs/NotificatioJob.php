<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\GarsonNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificatioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $userid,$table,$message;
    public function __construct($userid,$table,$message)
    {
        $this->userid =  $userid;
        $this->table =   $table;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userid);
        $user->notify(new GarsonNotification($this->table." ".$this->message));
     
    }
}
