<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\{Item,CartLocal, CartLocalDetail, ClientLocal};
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MyOrderComponent extends Component
{
    use LivewireAlert;
    public $totalOtherItems = 0, $totalDrinks= 0,$edit,$drinks = [], $others = [], $quantity = 1,$itemId;
    protected $listeners = ['cancel'=>'cancel','refresh'=>'refresh'];
    public function mount()
    {
        try {
            $clientelocal = ClientLocal::where('user_id','=',auth()->user()->id)->first();

            $listDrinksTotal =  CartLocalDetail::where('category','=','Bebidas')
            ->where('table','=',$clientelocal->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
            ->get();
           


            $listOtherItemsTotal =  CartLocalDetail::where('category','<>','Bebidas')
            ->where('table','=',$clientelocal->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
            ->get();
            
            foreach ($listDrinksTotal as  $value) {
           
                $this->totalOtherItems += ($value->price * $value->quantity);
            }

            foreach ($listOtherItemsTotal as  $value) {
           
                $this->totalDrinks += ($value->price * $value->quantity);
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
    public function render()
    {
        return view('livewire.client.my-order-component',[
            'itemsOrder'=>$this->listOtherItems(),
            'drinksOrder'=>$this->listDrinks(),
            'client'=>$this->getCurrentClient(),

        ])->layout('layouts.client.app');
    }


    public function getCurrentClient()
    {
        try {
         
          return  ClientLocal::where('user_id','=',auth()->user()->id)->first();
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


    //Listar pedidos
    public function listDrinks()
    {
        try {
            $clientelocal = ClientLocal::where('user_id','=',auth()->user()->id)->first();

            return CartLocalDetail::where('category','=','Bebidas')
            ->where('table','=',$clientelocal->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
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
    //Listar pedidos
    public function listOtherItems()
    {
        try {
            $clientelocal = ClientLocal::where('user_id','=',auth()->user()->id)->first();

            return CartLocalDetail::where('category','<>','Bebidas')
            ->where('table','=',$clientelocal->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
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



   //confirmar exclusao de  categoria
   public function confirm($id)
   {
       
      
       try {
           $this->edit = $id;
      
           $this->alert('warning', 'CONFIRMAR', [
               'icon' => 'warning',
               'position' => 'center',
               'toast' => false,
               'text' => "Deseja realmente cancelar este pedido? Não pode reverter a ação",
               'showConfirmButton' => true,
               'showCancelButton' => true,
               'cancelButtonText' => 'Cancelar',
               'confirmButtonText' => 'Confirmar',
               'confirmButtonColor' => '#3085d6',
               'cancelButtonColor' => '#d33',
               'onConfirmed' => 'cancel' 
           ]);
           
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

    
   

  
    public function cancel()
    {
        try {
            $cart = CartLocalDetail::find($this->edit);
           
            if($cart)
            {

                if($cart->status == 'PENDENTE')
                {
                    CartLocalDetail::destroy($this->edit);
                    $this->alert('success', 'SUCESSO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Operação Realizada Com Sucesso.'
                    ]);
                    
                    $this->dispatch('refresh');
                }else{
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Já não pode cancelar seu pedido, chame o garçon'
                    ]);
                }

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




    //encontrar o item para alterar a quantidade
    public function findItem($id)
    {
        try {
            $this->itemId = $id;
          
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
    //Actualizar a quantidade
    public function updateQuantity()
    {
        try {
            
            $cartDetail = CartLocalDetail::find($this->itemId);
            $item = Item::where('company_id','=',auth()->user()->company_id)
            ->where('description','=',$cartDetail->name)
            ->first();
            if($this->quantity > $item->quantity)
            {
                $this->alert('error', 'ERRO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Quantidade superior a disponível'
                ]);
            }else{

                $cartDetail->quantity = $this->quantity;
                $cartDetail->save();
    
                $this->dispatch('refresh');
                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'timer'=>500,
                    'text'=>'Quantidade Alterada.'
                ]);

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
   
}
