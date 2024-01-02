<?php

namespace App\Livewire\RoomManager;

use App\Models\Reserve as R;
use App\Models\Reserve;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ShowBookComponent extends Component
{
    use LivewireAlert;
    public $edit;
    protected $listeners = ['delete'=>'delete'];

    public function render()
    {
         

    //    $expiratereserve =  DB::table('reserves')->where('company_id','=',auth()->user()->company_id)
    //             ->whereDate('expiratedate','<',today())
    //             ->get();
          
 
        return view('livewire.room-manager.show-book-component',[
            'reserves'=>$this->getReserve()
        ])->layout('layouts.room_manager.app');
    }


    public function getReserve()
    {
        try {
           
            return DB::table('reserves')->where('company_id','=',auth()->user()->company_id)
            ->whereDate('expiratedate','>',today())
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
        
             $this->alert('warning', 'Confirmar', [
                 'icon' => 'warning',
                 'position' => 'center',
                 'toast' => false,
                 'text' => "Deseja realmente excluir? Não pode reverter a ação",
                 'showConfirmButton' => true,
                 'showCancelButton' => true,
                 'cancelButtonText' => 'Cancelar',
                 'confirmButtonText' => 'Excluir',
                 'confirmButtonColor' => '#3085d6',
                 'cancelButtonColor' => '#d33',
                 'onConfirmed' => 'delete' 
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
     public function delete()
     {
         
        
         try {


            DB::table('reserves')->delete($this->edit);
             
            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação realizada com sucesso'
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
