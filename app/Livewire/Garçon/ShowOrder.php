<?php

namespace App\Livewire\Garçon;

use App\Models\CartLocal;
use App\Models\GarsonTable;
use App\Models\Table;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ShowOrder extends Component
{
    use LivewireAlert;
    public $cancelAll,$cancelItem,$itemsOrder = [], $drinksOrder = [],$tableNumber = null;

    public function render()
    {
        return view('livewire.garson.show-order',[
            'allOrders'=>$this->getOrders($this->tableNumber),
            'allTables'=>$this->getTables()
        ])->layout('layouts.garson.app');
    }

    public function getOrders($table)
    {
        try {

         
            if($table !=null)
            {
                $this->itemsOrder =  CartLocal::join('cart_local_details','cart_locals.id','cart_local_details.cart_local_id')
                ->select('cart_locals.table','cart_locals.id as cartlocalid','cart_local_details.id','cart_local_details.created_at','cart_local_details.name','cart_local_details.price','cart_local_details.quantity','cart_local_details.status')
                ->where('cart_local_details.category','<>','Bebidas')
                ->where('cart_locals.user_id','=',auth()->user()->id)
                ->where('cart_locals.table','=',$table)
                ->where('cart_locals.company_id','=',auth()->user()->company_id)
                ->get();
               
                $this->drinksOrder = CartLocal::join('cart_local_details','cart_locals.id','cart_local_details.cart_local_id')
                ->select('cart_locals.table','cart_locals.id as cartlocalid','cart_local_details.id','cart_local_details.created_at','cart_local_details.name','cart_local_details.price','cart_local_details.quantity','cart_local_details.status')
                ->where('cart_local_details.category','=','Bebidas')
                ->where('cart_locals.user_id','=',auth()->user()->id)
                ->where('cart_locals.table','=',$table)
               ->where('cart_locals.company_id','=',auth()->user()->company_id)
                ->get();
                
            }else{
                
                $this->itemsOrder =  CartLocal::join('cart_local_details','cart_locals.id','cart_local_details.cart_local_id')
                ->select('cart_locals.table','cart_locals.id as cartlocalid','cart_local_details.id','cart_local_details.created_at','cart_local_details.name','cart_local_details.price','cart_local_details.quantity','cart_local_details.status')
                ->where('cart_local_details.category','<>','Bebidas')
                ->where('cart_locals.user_id','=',auth()->user()->id)
                ->where('cart_locals.company_id','=',auth()->user()->company_id)
                ->get();
                
                $this->drinksOrder = CartLocal::join('cart_local_details','cart_locals.id','cart_local_details.cart_local_id')
                ->select('cart_locals.table','cart_locals.id as cartlocalid','cart_local_details.id','cart_local_details.created_at','cart_local_details.name','cart_local_details.price','cart_local_details.quantity','cart_local_details.status')
                ->where('cart_local_details.category','=','Bebidas')
                ->where('cart_locals.user_id','=',auth()->user()->id)
                ->where('cart_locals.company_id','=',auth()->user()->company_id)
                ->get();
               
            }
            
             
        
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

    public function getTables()
    {
        try {

       
            return Table::where('company_id','=',auth()->user()->company_id)
            ->get();

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
