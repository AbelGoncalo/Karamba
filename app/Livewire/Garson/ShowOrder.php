<?php

namespace App\Livewire\Garson;

use App\Models\CartLocal;
use App\Models\CartLocalDetail;
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
                $this->itemsOrder =  CartLocalDetail::where('category','<>','Bebidas')
                ->where('table','=',$this->tableNumber)
                ->where('company_id','=',auth()->user()->company_id)
                ->get();
    
    
             
                $this->drinksOrder =  CartLocalDetail::where('category','=','Bebidas')
                ->where('table','=',$this->tableNumber)
                ->where('company_id','=',auth()->user()->company_id)
                ->get();
                
            }else{
                
                $this->itemsOrder =  CartLocalDetail::where('category','<>','Bebidas')
                ->where('company_id','=',auth()->user()->company_id)
                ->get();
    
    
             
                $this->drinksOrder =  CartLocalDetail::where('category','=','Bebidas')
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
