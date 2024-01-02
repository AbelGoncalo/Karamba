<?php

namespace App\Livewire\Site;

use App\Models\Delivery;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class FinallyComponent extends Component
{
    use LivewireAlert;
    public $search = '';
    protected $listeners = ['searchOrder'=>'render','redirect'=>'redirect'];


    public function mount()
    {
        $this->search = session('finddetail');
    }
    public function render()
    {
        return view('livewire.site.finally-component',[
            'orders'=>$this->searchOrder($this->search),
            'status'=>$this->getStatus($this->search)
        ])->layout('livewire.site.options.info');
    }


    public function searchOrder($search)
    {
        try {
           if(isset($search) and $search != null)
           {
                 return Delivery::join('delivery_details','deliveries.id','delivery_details.delivery_id')
                    ->select('delivery_details.item','delivery_details.quantity')
                    ->where('finddetail','=',$search)
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
    public function getStatus($search)
    {
        try {
           if(isset($search) and $search != null)
           {
                 $status =  Delivery::where('finddetail','=',$this->search)
                 ->first();

                 if($status == 'Entregue'){
                    $this->dispatch('redirect');
                    return $status;
                }else{
                    
                    return $status;
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
