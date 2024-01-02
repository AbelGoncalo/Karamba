<?php

namespace App\Livewire\RoomManager;

use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\{Review as showReview};
class ShowReviewComponent extends Component
{
    use LivewireAlert;
    public $date = null;
    public function render()
    {
        return view('livewire.room-manager.show-review-component',[
            'reviews'=>$this->getReviews($this->date)
        ])->layout('layouts.room_manager.app');
    }


    public function mount()
    {
        $this->date = date('Y-m-d');
    }



    public function getReviews($date)
    {
        try {

            if ($date != null)  {
             return   showReview::where('date','=',$date)
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
}
