<?php

namespace App\Livewire\Economate;

use Livewire\Component;

class OrderComponent extends Component
{
    public function render()
    {
        return view('livewire.economate.order-component')->layout("layouts.economate.app");
    }
}
