<?php

namespace App\Livewire\Treasury;

use Livewire\Component;

class MakeInvoice extends Component
{
    public function render()
    {
        return view('livewire.treasury.make-invoice')->layout('layouts.treasury.app');
    }
}
