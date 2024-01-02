<?php

namespace App\Livewire\RoomManager;

use App\Models\Delivery;
use Livewire\Component;

class DeliveryCount extends Component
{
    public function render()
    {
        return view('livewire.room-manager.delivery-count',[
            'deliveriesPendingCount'=>Delivery::where('status','=','PENDENTE')->limit(99)->count(),
        ]);
    }
}
