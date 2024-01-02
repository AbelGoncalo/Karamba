<?php

namespace App\Livewire\Admin;

use App\Exports\TableExport;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Table;
class TableComponent extends Component
{
    use LivewireAlert;
    public $number, $location,$edit,$search; 
    protected $rules = ['number'=>'required|unique:tables,number','location'=>'required'];
    protected $messages = ['number.required'=>'Obrigatório','number.unique'=>'Já Existe','location.required'=>'Obrigatório'];
    protected $listeners = ['close'=>'close','delete'=>'delete','changeStatus'=>'changeStatus'];

    public function render()
    {
        return view('livewire.admin.table-component',[
            'tables'=>$this->searchTable($this->search)
        ])->layout('layouts.admin.app');
    }


    //Salvar Table
    public function save()
    {
        $this->validate($this->rules,$this->messages);
        try {
         
            Table::create([
                'number'=>'Mesa '.$this->number,
                'location'=>$this->location,
                'company_id'=>auth()->user()->company_id,
            ]);

            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);

            $this->clear();

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
    //Editar Table
    public function editTable($id)
    {
        
       
        try {
            $table = Table::find($id);
            $this->edit = $table->id;
            $this->number = substr(trim($table->number),4) ;
            $this->location = $table->location;

            
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
    //confirmar mudança de estado da mesa
    public function confirmChangeStatus($id)
    {
        
       
        try {
            $this->edit = $id;
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente mudar o estado dessa mesa? Certifique se visualmente do estado actual da mesa",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'time'=>5000,
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
    //confirmar mudança de estado da mesa
    public function changeStatus()
    {
        
       
        try {
            
            $tableFinded = Table::find($this->edit);

            if ($tableFinded->status == 0) {
                $tableFinded->status = 1;
                $tableFinded->save();
                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Estado alterado com sucesso.'
                ]);
            } else {
                $tableFinded->status = 0;
                $tableFinded->save();
                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Estado alterado com sucesso.'
                ]);
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
    //Update Table
    public function update()
    {
       
        $this->validate([
            'number'=>'required|unique:tables,number,'.$this->edit,'location'=>'required'
        ],$this->messages);
       
        try {
  
            Table::find($this->edit)->update([
               'number'=>'Mesa '.$this->number,
               'location'=>$this->location,
            ]);
            

            $this->dispatch('close');
            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);

            $this->clear();

            
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
    //excluir Table
    public function delete()
    {
       
       
        try {
           
            Table::destroy($this->edit);
           
            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);

            $this->clear();
            
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
    //Pesquisar Categoria
    public function searchTable($search)
    {
        try {

            if($search != null)
            {
                return Table::where('number','like','%'.$search.'%')->latest()->get();
            }else{
                return Table::latest()->get();
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


     //Limpar campos
   public function clear()
   {
       $this->number  = '';
       $this->location  = '';
       $this->edit  = '';
       $this->search  = '';
   }


   public function export($format)
   {
       try {
        
           if($format == 'pdf')
           {
               return (new TableExport($this->search))->download('Mesas.'.$format,\Maatwebsite\Excel\Excel::DOMPDF); 
               
           }elseif($format == 'xls')
           {
               return (new TableExport($this->search))->download('Mesas.'.$format,\Maatwebsite\Excel\Excel::XLS); 

           }

       } catch (\Throwable $th) {
          
        $this->alert('warning', 'AVISO', [
            'toast'=>false,
            'position'=>'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'OK',
            'text'=>'Sem dados para exportar'
        ]);
       }
   }


}
