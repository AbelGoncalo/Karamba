<?php

namespace App\Livewire\Economate;

use App\Models\CategoryEconomate;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CategoryComponent extends Component
{
    use LivewireAlert;
    public $description,$edit,$search;

    protected $rules = ['description'=>'required|unique:category_economates,description'];
    protected $messages = ['description.required'=>'Obrigatório','description.unique'=>'Já Existe'];
    protected $listeners = ['close'=>'close','delete'=>'delete'];
    public function render()
    {
        return view('livewire.economate.category-component',[
            'categories'=>$this->searchCategory($this->search),

        ])->layout('layouts.economate.app');
    }

        //Salvar Categoria
        public function save()
        {
            $this->validate($this->rules,$this->messages);
            try {
              
    
                CategoryEconomate::create([
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
        public function editCategory($id)
        {
            
           
            try {
               
                $category = CategoryEconomate::find($id);
                $this->edit = $category->id;
                $this->description = $category->description;
    
                
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
                'description'=>'required|unique:category_economates,description,'.$this->edit
            ],$this->messages);
           
            try {
               
     
            CategoryEconomate::find($this->edit)->update([
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
               
                CategoryEconomate::destroy($this->edit);
               
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
        public function searchCategory($search)
        {
            try {
    
                if($search != null)
                {
                    return CategoryEconomate::where('company_id','=',auth()->user()->company_id)->where('description','like','%'.$search.'%')->latest()->get();
                }else{
                    return CategoryEconomate::where('company_id','=',auth()->user()->company_id)->latest()->get();
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
