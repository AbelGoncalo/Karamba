<?php

namespace App\Livewire\RoomManager;

use App\Models\ServiceControl as Model;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ServiceControl extends Component
{

    use LivewireAlert;
    public $startdate = null,$enddate = null,$avgtime = 0;
     public function mount()
     {
         $this->startdate =  Carbon::parse($this->startdate)->format('Y-m-d');
         $this->enddate   = Carbon::parse($this->enddate )->format('Y-m-d');
 
     }


    public function render()
    {
        return view('livewire.room-manager.service-control',[
            'list'=>$this->getServiceControl($this->startdate,$this->enddate)
        ])->layout('layouts.room_manager.app');
    }


    public function getServiceControl($startdate,$enddate)
    {
        try {
          
            if ($startdate != null and $enddate != null) {

                $start =  Carbon::parse($startdate)->format('Y-m-d'). ' 00:00:00';
                $end   = Carbon::parse($enddate )->format('Y-m-d').' 23:59:59';

                $this->avgtime =Model::whereBetween('created_at',[$start,$end])
                ->where('company_id','=',auth()->user()->company_id)
                ->avg('time');
               
               

                return  Model::whereBetween('created_at',[$start,$end])
                ->where('company_id','=',auth()->user()->company_id)
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


   
}
