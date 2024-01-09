<?php

namespace App\Livewire\Barman;

use App\Jobs\NotificatioJob;
use App\Models\CartLocalDetail;
use App\Models\GarsonTable;
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
            'allTables'=>$this->getTable()
        ])->layout('layouts.barman.app');
    }

    public function getOrders($tableNumber)
    {
        try {
            
            if($tableNumber !=null)
            {
                return CartLocalDetail::where('table','=',$this->tableNumber)
                ->where('company_id','=',auth()->user()->company_id)
                ->where('category','=','Bebidas')
                ->where('status','=','PENDENTE')
                ->get();
               
            }else{
               
                return CartLocalDetail::where('company_id','=',auth()->user()->company_id)
                ->where('category','=','Bebidas')
                ->where('status','=','PENDENTE')
                ->get();

            }
        
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
               
               

                $garsontable = GarsonTable::where('table',$cartdetail->table)
                ->first(); 

                if($garsontable->status == 'Turno Aberto'){
                    
                    
                    NotificatioJob::dispatch($garsontable->user_id,$garsontable->table,"ALERTA DE PEDIDO DE BEBIDA PRONTA,DEVE SE DIRIGIR AO BAR PARA BUSCAR");
                }
                
                $this->getOrders($this->tableNumber);
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


     public function getTable()
     {
        try {
          return   Table::where('company_id','=',auth()->user()->company_id)->get();
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
