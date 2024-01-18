<?php

namespace App\Livewire\Chef;

use App\Events\NotificationEvent;
use App\Jobs\NotificatioJob;
use Livewire\Component;
use App\Models\{CartLocal, CartLocalDetail, GarsonTable, GarsonTableManagement, HistoryOfAllActivities, NotificationGarson, Table, User};
use App\Notifications\GarsonNotification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class HomeComponent extends Component
{
    use LivewireAlert;
    protected $listeners = ['deliveryed'=>'deliveryed','changeStatus'=>'changeStatus'];
    public $preparid,$deliveryid,$status;
    public $tableNumber = null;
    public function render()
    {
        return view('livewire.chef.home-component',[
            'allOrders'=>$this->getOrders($this->tableNumber),
            'allTables'=>$this->getTable()
        ])->layout('layouts.chef.app');
    }
    
    
    public function getTable()
    {
        try{
            return Table::where('company_id','=',auth()->user()->company_id)->get();
        }catch(\Throwable $th)
        {
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

    public function getOrders($tableSearch)
    {
        try {
          
            
            if(isset($tableSearch) and $tableSearch  != null)
            {
                

                return  CartLocalDetail::where('table','=',$this->tableNumber)
                ->where('company_id','=',auth()->user()->company_id)
                ->where('category','<>','Bebidas')
                ->where('status','<>','PRONTO')
                ->get();
    
    
             
      
            }else{

              return CartLocalDetail::where('company_id','=',auth()->user()->company_id)
              ->where('category','<>','Bebidas')
              ->where('status','<>','PRONTO')
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

            //Log para o registo da mudança de status para em Preparação
            $log = new HistoryOfAllActivities();
            $log->company_id = auth()->user()->company_id;
            $log->tipo_acao = "Alterar status da mesa";
            $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
            $log->descricao = "O chefe de sala ".auth()->user()->name.' '.auth()->user()->lastname.' alterou o status da mesa '.$cartdetail->table.' para '.$this->status;
            $log->save();

            if ($this->status == 'PRONTO') {
               

                $garsontable = GarsonTable::where('table',$cartdetail->table)
                ->first(); 

                if($garsontable->status == 'Turno Aberto'){
                        
                    NotificatioJob::dispatch($garsontable->user_id,$garsontable->table,"ALERTA DE PEDIDO PRONTO,DEVE SE DIRIGIR A COZINHA PARA BUSCAR");
                }
                 
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
   
}
