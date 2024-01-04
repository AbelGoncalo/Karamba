<?php

namespace App\Livewire\RoomManager;

use App\Models\CartLocal;
use App\Models\CartLocalDetail;
use App\Models\Table;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HomeComponent extends Component
{
    use LivewireAlert;
    protected $listeners = ['cancelOrder'=>'cancelOrder'];
    public $cancelAll,$cancelItem,$itemsOrder = [], $drinksOrder = [],$tableNumber;
    public function render()
    {
        return view('livewire.room-manager.home-component',[
            'allOrders'=>$this->getOrders($this->tableNumber),
            'allTables'=>$this->getTables(),
        ])->layout('layouts.room_manager.app');
    }

    public function getOrders($table)
    {
        try {

         
            if($table !=null)
            {
                $this->itemsOrder =  CartLocalDetail::where('table','=',$this->tableNumber)
                ->where('company_id','=',auth()->user()->company_id)
                ->where('category','<>','Bebidas')
                ->where('status','<>','PRONTO')
                ->get();
               
                $this->drinksOrder = CartLocalDetail::where('table','=',$this->tableNumber)
                ->where('company_id','=',auth()->user()->company_id)
                ->where('category','=','Bebidas')
                ->where('status','<>','PRONTO')
                ->get();;

            
                
            }else{
                
                $this->itemsOrder =  CartLocalDetail::
                where('company_id','=',auth()->user()->company_id)
                ->where('category','<>','Bebidas')
                ->where('status','<>','PRONTO')
                ->get();;

               
               
                $this->drinksOrder = CartLocalDetail::
                where('company_id','=',auth()->user()->company_id)
                ->where('category','<>','Bebidas')
                ->where('status','<>','PRONTO')
                ->get();;

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

     //confirmar exclusao de  categoria
     public function confirmCancelAll($id)
     {
         
        
         try {
             $this->cancelAll = $id;
        
             $this->alert('warning', 'Confirmar', [
                 'icon' => 'warning',
                 'position' => 'center',
                 'toast' => false,
                 'text' => "Deseja realmente cancelar todos os pedidos dessa mesa? Não pode reverte está ação",
                 'showConfirmButton' => true,
                 'showCancelButton' => true,
                 'cancelButtonText' => 'Cancelar',
                 'confirmButtonText' => 'OK',
                 'confirmButtonColor' => '#3085d6',
                 'cancelButtonColor' => '#d33',
                 'onConfirmed' => 'cancelOrder' 
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
     //confirmar exclusao de  categoria
     public function confirmCancelItem($id)
     {
         
        
         try {
             $this->cancelItem = $id;
            $cartDetailItem  =  CartLocalDetail::find($id);
        
             $this->alert('warning', 'Confirmar', [
                 'icon' => 'warning',
                 'position' => 'center',
                 'toast' => false,
                 'text' => "Deseja realmente cancelar o pedido de ".$cartDetailItem->name."? Não pode reverter está ação.",
                 'showConfirmButton' => true,
                 'showCancelButton' => true,
                 'cancelButtonText' => 'Cancelar',
                 'confirmButtonText' => 'OK',
                 'confirmButtonColor' => '#3085d6',
                 'cancelButtonColor' => '#d33',
                 'onConfirmed' => 'cancelOrder' 
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


         public function cancelOrder()
         {
            try {
                if($this->cancelItem != null)
                {
                    CartLocalDetail::destroy($this->cancelItem);
                    $this->alert('success', 'SUCESSO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Operação Realizada Com Sucesso.'
                    ]);

                    $this->cancelItem  = '';

                }elseif($this->cancelAll)
                {
                    $cartlocal = CartLocal::find($this->cancelAll);
                    CartLocalDetail::where('cart_local_id','=',$cartlocal->id)
                    ->where('company_id','=',auth()->user()->company_id)
                    ->delete();
                    $this->cancelAll = '';
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


