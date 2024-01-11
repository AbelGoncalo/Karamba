<?php

namespace App\Livewire\RoomManager;

use App\Models\CartLocalDetail;
use App\Models\Table;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class TransferComponent extends Component
{
    use LivewireAlert;
    public $tableNumber,$table, $check = [],$orders = [];
    public function render()
    {

        
      
        return view('livewire.room-manager.transfer-component',[
            'orders'=>$this->getOrders($this->tableNumber),
            'allTables'=>$this->getTables(),
        ])->layout('layouts.room_manager.app');
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


    public function getOrders($table)
    {
        try {
            if($table != null)
            {
                $this->orders =  CartLocalDetail::
                where('company_id','=',auth()->user()->company_id)
                ->where('table','=',$table)
                ->get();
            }else{
                
              
               
                $this->orders =  CartLocalDetail::
                where('company_id','=',auth()->user()->company_id)
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


    public function trasnferirItems()
    {
        try {

        if(isset($this->check) and count($this->check) > 0)
        {
            foreach ($this->check as  $value) {
                
             
               $item =   CartLocalDetail::find($value);
               $item->table = $this->table;
               $item->save();

            }

            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação realizada com sucesso'
            ]);
            $this->getOrders($this->table);
        }else{
            $this->alert('warning', 'AVISO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Nenhum item selecionado para transferência'
            ]);

            $this->getOrders($this->table);


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
