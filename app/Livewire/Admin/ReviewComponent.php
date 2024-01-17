<?php

namespace App\Livewire\Admin;

use App\Models\HistoryOfAllActivities;
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

              //Log para atualizar o status do da avaliação do produto feita pelo cliente
              $log = new HistoryOfAllActivities();
              $log->tipo_acao = 'Atualizar status de avaliação do produto';
              $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
              $log->company_id = auth()->user()->company_id;
              $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' atualizou o status de avaliação do produto '.$review->item;
              $log->save();
            
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
            
        //Log para atualizar o status do da avaliação do produto feita pelo cliente
        $review = Review::find($this->edit);
        $log = new HistoryOfAllActivities();
        $log->tipo_acao = 'Excluir avaliação do produto';
        $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
        $log->company_id = auth()->user()->company_id;
        $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' excluiu a avaliação do item '.$review->item.' que continha o comentário '.$review->comment;
        $log->save();

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
