<?php

namespace App\Livewire\Economate;

use App\Models\Compartment;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CompartmentComponent extends Component
{
    use LivewireAlert;
    public $description,$edit,$search;

    protected $rules = ['description'=>'required|unique:compartments,description'];
    protected $messages = ['description.required'=>'Obrigatório','description.unique'=>'Já Existe'];
    protected $listeners = ['close'=>'close','delete'=>'delete'];

    public function render()
    {
        return view('livewire.economate.compartment-component',[
            'compartments'=>$this->searchCompartment($this->search),

        ])->layout('layouts.economate.app');
    }

    public function save()
        {
            $this->validate($this->rules,$this->messages);
            try {
              
    
                Compartment::create([
                    'description'=>$this->description,
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
        //Editar categoria
        public function editCompartment($id)
        {
            
           
            try {
               
                $compartment = Compartment::find($id);
                $this->edit = $compartment->id;
                $this->description = $compartment->description;
    
                
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
        //Update categoria
        public function update()
        {
            $this->validate([
                'description'=>'required|unique:compartments,description,'.$this->edit
            ],$this->messages);
           
            try {
               
     
            Compartment::find($this->edit)->update([
                'description'=>$this->description,
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
                $this->dispatch('close');
    
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
        //excluir categoria
        public function delete()
        {
           
           
            try {
               
                Compartment::destroy($this->edit);
               
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
        public function searchCompartment($search)
        {
            try {
    
                if($search != null)
                {
                    return Compartment::where('company_id','=',auth()->user()->company_id)->where('description','like','%'.$search.'%')->latest()->get();
                }else{
                    return Compartment::where('company_id','=',auth()->user()->company_id)->latest()->get();
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
            $this->description = '';
            $this->edit = '';
            $this->search = '';
        }
}
