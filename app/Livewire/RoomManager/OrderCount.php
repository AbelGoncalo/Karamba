<?php

namespace App\Livewire\RoomManager;

use App\Models\CartLocalDetail;
use App\Models\Order;
use Livewire\Component;

class OrderCount extends Component
{
    public function render()
    {
        return view('livewire.room-manager.order-count',[
            'ordersPendingCount'=>CartLocalDetail::where('status','=','PENDENTE')->limit(99)->count(),
        ]);
    }
}
