<?php

namespace App\Livewire\Admin;

use App\Models\Review;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ReviewComponent extends Component
{
    use LivewireAlert;
    public $edit;
    protected $listeners = ['delete'=>'delete','changeStatus'=>'changeStatus'];
    public function render()
    {
        return view('livewire.admin.review-component',[
            'reviews'=>$this->listReview()
        ])->layout('layouts.admin.app');
    }

    public function listReview()
    {
        try {
                return Review::where('site','=','site')
                        ->where('company_id','=',auth()->user()->company_id)        
                        ->whereBetween('created_at',[date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59'])        
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


     //excluir Usuarios
     public function changeStatus()
     {
        
        
         try {
            
             $review  = Review::find($this->edit);
             ($review->status == 1)? $review->status = 0 : $review->status = 1;
             $review->save();
            
             $this->alert('success', 'SUCESSO', [
                 'toast'=>false,
                 'position'=>'center',
                 'showConfirmButton' => true,
                 'confirmButtonText' => 'OK',
                 'text'=>'Operação Realizada Com Sucesso.'
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
     //excluir avaliação
     public function delete()
     {
        
        
         try {
            
             Review::destroy($this->edit);
            
             $this->alert('success', 'SUCESSO', [
                 'toast'=>false,
                 'position'=>'center',
                 'showConfirmButton' => true,
                 'confirmButtonText' => 'OK',
                 'text'=>'Operação Realizada Com Sucesso.'
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

      //confirmar exclusao de  Usuarios
    public function confirm($id)
    {
        
       
        try {
            $this->edit = $id;
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente mudar o estado desta avaliação?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Mudar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'onConfirmed' => 'changeStatus' 
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

      //confirmar exclusao de  Usuarios
    public function confirmDelete($id)
    {
        
       
        try {
            $this->edit = $id;
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente excluir está  avaliação? Não pode reverter está ação.",
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
}
