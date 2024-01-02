<?php

namespace App\Livewire\Chef;

use App\Models\Delivery;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DeliveryCount extends Component
{
    use LivewireAlert;
    protected $listeners = ['countDeliveries'=>'countDeliveries'];
    public function render()
    {
        return view('livewire.chef.delivery-count',[
            'deliveriesPendingCount'=> $this->countDeliveries()

        ]);
    }


    public function countDeliveries()
    {
        try {
            return Delivery::where('status','=','ACEITE')
            ->orWhere('status','=','EM PREPARAÇÃO')
            ->count();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }
}
