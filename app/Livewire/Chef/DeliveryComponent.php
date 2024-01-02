<?php

namespace App\Livewire\Chef;

use App\Models\Delivery;
use App\Models\DeliveryDetail;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class DeliveryComponent extends Component
{
    use LivewireAlert;
    public $details = [],$statusvalue = [];
    protected $listeners = ['searchOrder'=>'searchOrder'];
    public function render()
    {
        return view('livewire.chef.delivery-component',[
            'deliveries'=>$this->getDeliveries(),
        ])->layout('layouts.chef.app');
    }

    public function getDeliveries()
    {
        try {
         
               return Delivery::where('status','=','ACEITE')
               ->orWhere('status','=','EM PREPARAÇÃO')
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


    public function getDetail($id){
        try {
          $this->details =    DeliveryDetail::where('delivery_id','=',$id)->get();
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


    public function changeStatus($id)
    {
        try {
           $delivery =  Delivery::where('company_id','=',auth()->user()->company_id)
           ->where('id','=',$id)
           ->first();
          
           if($delivery->status == 'ACEITE')
           {
                if ($this->statusvalue[$id] == 'PRONTO') {

                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Ainda não foi preparado, não pode colocar como pronto.'
                    ]);
                }else{
                    $delivery->status = $this->statusvalue[$id];
                    $delivery->save();

                    if($delivery)
                    {
                    $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Estado Alterado.'
                    ]);

                }
            }
            $this->dispatch('countDeliveries');
           }else{
            $delivery->status = $this->statusvalue[$id];
            $delivery->save();

            if($delivery)
            {
                $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Estado Alterado.'
                ]);

                $this->dispatch('countDeliveries');
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
}
