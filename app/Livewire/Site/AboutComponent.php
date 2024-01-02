<?php

namespace App\Livewire\Site;

use Livewire\Component;

class AboutComponent extends Component
{
    public function render()
    {
        return view('livewire.site.about-component')->layout('layouts.site.app');
    }
}
