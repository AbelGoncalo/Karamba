<?php

namespace App\Livewire\Control;

use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        return view('livewire.control.home-component')->layout('layouts.control.app');
    }
}
