<?php

namespace App\Livewire\Admin;

use App\Models\DailyDish;
use Livewire\Component;

class DishOfTheDayComponent extends Component
{
    public function render()
    {
        $response['dailyOfTheDay'] = DailyDish::where("company_id", auth()->user()->company_id)->get();
        return view('livewire.admin.dailydish-component',$response)->layout('layouts.admin.app');
    }
}
