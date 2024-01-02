<?php

namespace App\Livewire\RoomManager;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ReserveCount extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view('livewire.room-manager.reserve-count',[
            'reserveCount'=>$this->countReserve()
        ]);
    }


    public function countReserve()
    {
        try {
           
            return DB::table('reserves')->where('company_id','=',auth()->user()->company_id)
            ->whereDate('expiratedate','>',today())
            ->count();

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
