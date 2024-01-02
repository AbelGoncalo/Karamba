<?php

namespace App\Livewire\Site;

use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
class CartCount extends Component
{
    protected $listeners = ['getTotalItems'=>'getTotalItems'];
    public function render()
    {
        return view('livewire.site.cart-count',[
            'totalItems'=>$this->getTotalItems()
        ]);
    }


    public function getTotalItems()
    {
        try {
            return \Cart::getContent();
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
