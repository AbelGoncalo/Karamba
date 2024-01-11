<?php

namespace App\Livewire\Garçon;

use Livewire\Component;
use App\Models\{Table,CartLocal,CartLocalDetail, DetailOrder, GarsonTable, HistoryOfAllActivities, Item, ServiceControl};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ViewOrderComponent extends Component
{
    use LivewireAlert;
    public $tableNumber,$itemsOrder = [],$drinksOrder = [], $quantity = 1, $itemId = null ,$edit = null;
    protected $listeners = ['cancel'=>'cancel','change'=>'change','close'=>'close'];
    public function render()
    {
        return view('livewire.garson.view-order-component',[
            'allTables'=>$this->getTables()
        ])->layout('layouts.garson.app');
    }


    public function getOrders()
    {
        try {
           
 
            if ($this->tableNumber  != null) {
            
           $this->itemsOrder =  CartLocalDetail::where('category','<>','Bebidas')
            ->where('table','=',$this->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
            ->get();


         
            $this->drinksOrder =  CartLocalDetail::where('category','=','Bebidas')
            ->where('table','=',$this->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
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

        
            return GarsonTable::where('user_id','=',auth()->user()->id)
            ->where('company_id','=',auth()->user()->company_id)
            ->where('status','=','Turno Aberto')
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
            $this->getOrders();
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
               
               $item = Item::where('description','=',$cart->name)->first();
               $item->quantity += $cart->quantity;
               $item->save();
             
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
                   
              $this->getOrders();

             //Cancelando a  atividade na tabela de Log 
             $log_registers = new HistoryOfAllActivities();
             $log_registers->tipo_acao = "Cencelar pedido";
             $log_registers->descricao = "O Garçon ".auth()->user()->name." cancelou " .$cart->quantity. ($cart->quantity > 1 ? " quantidades " : " quantidade " ). " do pedido de ".$cart->name. "em estado". $cart->status;
             $log_registers->responsavel = auth()->user()->name;
             $log_registers->company_id = auth()->user()->company_id;
             $log_registers->save();


            }else{
                   $this->getOrders();
                   $this->alert('warning', 'AVISO', [
                       'toast'=>false,
                       'position'=>'center',
                       'showConfirmButton' => true,
                       'confirmButtonText' => 'OK',
                       'text'=>'Já não pode cancelar este pedido'
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
            $this->getOrders();
          
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
            $itemFinded = Item::where('description','=',$cartDetail->name)
            ->first();



            if ($this->quantity > $itemFinded->quantity) {

                 $this->alert('warning', 'AVISO', [
                     'toast'=>false,
                     'position'=>'center',
                     'showConfirmButton' => true,
                     'confirmButtonText' => 'OK',
                     'text'=>'Quantidade superior a disponível.'
                 ]);

                 $this->getOrders();


             } else {

            //Atualizando a quantidade atividade de pedidos na tabela de Log para o acto de atualizar pedidos
            $log_registers = new HistoryOfAllActivities();
            $lastQuantity = $cartDetail->quantity;
            $log_registers->tipo_acao = "Atualizar pedido";
            $log_registers->descricao = "O Garçon ".auth()->user()->name." atualizou a quantidade do pedido de " .$lastQuantity. " para  " .$this->quantity. ($lastQuantity > 1 ? " quantidades " : " quantidade " );
            $log_registers->responsavel = auth()->user()->name;
            $log_registers->save(); 

                 

             $cartDetail->quantity = $this->quantity;
             $cartDetail->save();

             $this->quantity = 1;
             $this->itemId = '';
             $this->dispatch('close');

                      
            

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
    public function confirmChangeStatus($id)
    {
        try {
            $this->edit = $id;
            $this->getOrders();
            $this->alert('warning', 'CONFIRMAR', [
               'icon' => 'warning',
               'position' => 'center',
               'toast' => false,
               'text' => "Mudar para entregue? Não pode reverter a ação",
               'showConfirmButton' => true,
               'showCancelButton' => true,
               'cancelButtonText' => 'Cancelar',
               'confirmButtonText' => 'Confirmar',
               'confirmButtonColor' => '#3085d6',
               'cancelButtonColor' => '#d33',
               'onConfirmed' => 'change' 
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
    public function change()
    {
        DB::beginTransaction();
        try {
            if ($this->edit != null) {
                
                $order = CartLocalDetail::find($this->edit);
                $order->status = 'ENTREGUE';
                $order->save();


               //Registrar tempo de entrega do pedido
               ServiceControl::create([
                'item'=>$order->name,
                'time'=>Carbon::parse($order->created_at)->format('s'),
                'company_id'=>auth()->user()->company_id,
               ]);

                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação Realizada Com Sucesso.'
                ]);
                $this->getOrders();
            }  

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




    
}
