<?php

namespace App\Livewire\Economate;

use App\Models\CategoryEconomate;
use App\Models\ProductEconomate;
use Livewire\{Component,WithFileUploads};
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductComponent extends Component
{
    use LivewireAlert,WithFileUploads;
    public $description,$edit,$search,$category,$image,$unit;

    protected $rules = ['description'=>'required|unique:product_economates,description'];
    protected $messages = ['description.required'=>'Obrigatório','description.unique'=>'Já Existe'];
    protected $listeners = ['close'=>'close','delete'=>'delete'];

    public function render()
    {
        return view('livewire.economate.product-component',[
            'products'=>$this->searchProduct($this->search),
            'categories'=>CategoryEconomate::where('company_id','=',auth()->user()->company_id)->get()

        ])->layout('layouts.economate.app');
    }

           //Salvar Categoria
           public function save()
           {
               $this->validate($this->rules,$this->messages);
               try {

                $imageString = '';

                if($this->image)
                {
               
                    $imageString = md5($this->image->getClientOriginalName()).'.'.
                    $this->image->getClientOriginalExtension();
                    $this->image->storeAs('/public/economato/',$imageString);
    
                }
                 
       
                   ProductEconomate::create([
                       'description'=>$this->description,
                       'image'=>$imageString,
                       'unit'=>$this->unit,
                       'company_id'=>auth()->user()->company_id,
                       'category_economate_id'=>$this->category,
                       'company_id'=>auth()->user()->company_id
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
           public function editProduct($id)
           {
               
              
               try {
                  
                   $product = ProductEconomate::find($id);
                   $this->edit = $product->id;
                   $this->description = $product->description;
                   $this->category = $product->category_economate_id;
                   $this->cost = $product->cost;
       
                   
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
                   'description'=>'required|unique:product_economates,description,'.$this->edit
               ],$this->messages);
              
               try {
                  
                $imageString = '';
                if($this->image and !is_string($this->image))
                {
               
                    $imageString = md5($this->image->getClientOriginalName()).'.'.
                    $this->image->getClientOriginalExtension();
                    $this->image->storeAs('/public/economato/',$imageString);


                    ProductEconomate::find($this->edit)->update([
                        'description'=>$this->description,
                        'category_id'=>$this->category,
                        'image'=>$imageString,
                        'cost'=>$this->cost,
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
    
                }else{

                    ProductEconomate::find($this->edit)->update([
                        'description'=>$this->description,
                        'category_id'=>$this->category,
                        'cost'=>$this->cost,
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
           //excluir categoria
           public function delete()
           {
              
              
               try {
                  
                ProductEconomate::destroy($this->edit);
                  
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
           public function searchProduct($search)
           {
               try {
       
                   if($search != null)
                   {
                       return ProductEconomate::where('company_id','=',auth()->user()->company_id)->where('description','like','%'.$search.'%')->latest()->get();
                   }else{
                       return ProductEconomate::where('company_id','=',auth()->user()->company_id)->latest()->get();
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
                $this->cost = '';
               $this->search = '';
               $this->category = '';
           }
   
}
