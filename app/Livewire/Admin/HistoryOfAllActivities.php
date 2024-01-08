<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class HistoryOfAllActivities extends Component
{
    public function render()
    {
        return view('livewire.admin.history-of-all-activities')->layout('layouts.admin.app');
    }
}
