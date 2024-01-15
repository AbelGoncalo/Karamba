<?php

namespace App\Livewire\Garson;

use App\Models\Company;
use App\Models\DetailOrder;
use App\Models\GarsonTable;
use App\Models\NotificationGarson;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationComponent extends Component
{
    use LivewireAlert;
    public $edit,$tableNumber = null;
    protected $listeners = ['confirmPayment'=>'confirmPayment','countNotificationsByGarson'=>'countNotificationsByGarson'];


    public function render()
    {
        return view('livewire.garson.notification-component',[
            'notifications'=>$this->countNotificationsByGarson(),
            'listNotifications'=>$this->getNotificationsByGarson(),
            'allTables'=>GarsonTable::where('user_id','=',auth()->user()->id)
            ->where('status','=','Turno Aberto')
            ->get()
        ]);
    }


    public function countNotificationsByGarson()
    {
        try {
            $garsontable =   GarsonTable::where('status','=','Turno Aberto')
            ->where('user_id','=',auth()->user()->id)
            ->first();
            
            if($garsontable)
            {
                    
               return NotificationGarson::where('garson_table_id','=',$garsontable->id)
                            ->where('status','=','0')
                            ->count();
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
    public function getNotificationsByGarson()
    {
        try {
             $garsontable =   GarsonTable::where('status','=','Turno Aberto')
            ->where('user_id','=',auth()->user()->id)
            ->first();
            
            
          
          
            if($garsontable)
            {
               
                   
                    return NotificationGarson::where('garson_table_id','=',$garsontable->id)
                            ->where('status','=','0')
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

    public function confirmPayment()
    {
        DB::beginTransaction();
        try {
           $notification =  NotificationGarson::find($this->edit);
           $order = Order::find($notification->paymentid);
      
         
           $order->status = 1;
           $order->reference = $notification->reference;
           $order->save();
           $notification->status = 1;
           $notification->save();

           $table = Table::where('number','=',$notification->tableNumber)->first();
           $table->status = 0;
           $table->save();
           
          DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
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
     public function confirmAction($id)
     {
         
        
         try {
             $this->edit = $id;
        
             $this->alert('warning', 'Confirmar', [
                 'icon' => 'warning',
                 'position' => 'center',
                 'toast' => false,
                 'text' => "Deseja realmente confirmar este pagamento? Não pode reverter a ação",
                 'showConfirmButton' => true,
                 'showCancelButton' => true,
                 'cancelButtonText' => 'Cancelar',
                 'confirmButtonText' => 'OK',
                 'confirmButtonColor' => '#3085d6',
                 'cancelButtonColor' => '#d33',
                 'onConfirmed' => 'confirmPayment' 
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
     public function download($id)
     {
         
    
         try {
            $notification =  NotificationGarson::find($id);
            $order = Order::find($notification->paymentid);
            if ($order->file_receipt != null) {

                session()->put('download_confirmed'.$notification->id,1);
                return  response()->download(storage_path().'/app/public/comprovativos_pagamentos_trans/'.$order->file_receipt);
                 
            }else{
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'time'=>2000,
                    'text'=>'O pagamento não foi realizado por outra via... Deve verificar por a via no qual foi paga.'
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
     //confirmar exclusao de  categoria
     public function saw(string $id)
     {
         
         try {
            Auth::user()->notifications
            ->where('id',$id)
            ->first()->markAsRead();

            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Marcada como lida!!!'
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
}
