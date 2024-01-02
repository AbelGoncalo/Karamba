<?php

namespace App\Livewire\Barman;

use App\Jobs\NotificatioJob;
use App\Models\CartLocal;
use App\Models\CartLocalDetail;
use App\Models\GarsonTable;
use App\Models\NotificationGarson;
use App\Models\Table;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class HomeComponent extends Component
{
    use LivewireAlert;
    protected $listeners = ['deliveryed'=>'deliveryed','changeStatus'=>'changeStatus'];
    public $preparid,$deliveryid,$status;
    public $tableNumber = null;
    public function render()
    {
        return view('livewire.barman.home-component',[
            'allOrders'=>$this->getOrders($this->tableNumber),
            'allTables'=>Table::where('company_id','=',auth()->user()->company_id)->get()
        ])->layout('layouts.barman.app');
    }

    public function getOrders($tableSearch)
    {
        try {
            if(isset($tableSearch) and $tableSearch  != null)
            {
               return CartLocal::join('cart_local_details','cart_locals.id','cart_local_details.cart_local_id')
                ->select('cart_locals.table','cart_locals.id as cartlocalid','cart_local_details.id','cart_local_details.created_at','cart_local_details.name','cart_local_details.price','cart_local_details.quantity','cart_local_details.status')
                ->where('cart_local_details.category','=','Bebidas')
                ->where('cart_locals.table','=',$tableSearch)
                ->where('cart_local_details.status','=','PENDENTE')
                ->orWhere('cart_local_details.status','=','EM PREPARAÇÃO')
                ->where('cart_locals.company_id','=',auth()->user()->company_id)
                ->get();

            }else{

              return  CartLocal::join('cart_local_details','cart_locals.id','cart_local_details.cart_local_id')
                ->select('cart_locals.table','cart_locals.id as cartlocalid','cart_local_details.id','cart_local_details.created_at','cart_local_details.name','cart_local_details.price','cart_local_details.quantity','cart_local_details.status')
                ->where('cart_local_details.category','=','Bebidas')
                ->where('cart_local_details.status','=','PENDENTE')
                ->orWhere('cart_local_details.status','=','EM PREPARAÇÃO')
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

     //confirmar exclusao de  categoria
     public function confirmChangeStatus($id,$status)
     {
         
        
         try {
             $this->preparid = $id;
             $this->status = $status;
        
             $this->alert('warning', 'Confirmar', [
                 'icon' => 'warning',
                 'position' => 'center',
                 'toast' => false,
                 'text' => "Deseja realmente mudar o estado do pedido?",
                 'showConfirmButton' => true,
                 'showCancelButton' => true,
                 'cancelButtonText' => 'Cancelar',
                 'confirmButtonText' => 'OK',
                 'confirmButtonColor' => '#3085d6',
                 'cancelButtonColor' => '#d33',
                 'onConfirmed' => 'changeStatus' 
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
    

     public function changeStatus()
     {
        try {
            $cartdetail =  CartLocalDetail::find($this->preparid);
            $cartdetail->status = $this->status;
            $cartdetail->save();
            $this->getOrders($this->tableNumber);
          

            if ($this->status == 'PRONTO') {
                
                $cartlocal = CartLocal::find($cartdetail->cart_local_id);
                $garsontable = GarsonTable::whereJsonContains('table',$cartlocal->table)
                ->where('status','=','Turno Aberto')
                ->first(); 
    
                NotificatioJob::dispatch($cartlocal->user_id,$cartlocal->table,"ALERTA DE PEDIDO DE BEBIDA PRONTA,DEVE SE DIRIGIR AO BAR PARA BUSCAR");

          
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
