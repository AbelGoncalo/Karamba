<?php

namespace App\Livewire\Site;

use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ShowRatingComponent extends Component
{
    use LivewireAlert;
    public $comments = '';
    protected $listeners = ['reload'=>'reload'];
    public function render()
    {
        return view('livewire.site.show-rating-component',[
            'ratings'=>$this->getRatings()
            
        ]);
    }


    public function getMessage($id)
    {
        try {
        
         $this->comments =   Review::find($id)->comment;
        
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

    public function fresh()
    {
        try {
        
         $this->dispatch('reload');
        
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


    public function getRatings()
    {
        try {
          
            return Review::where('site','=','Site')->get();
           

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
