<?php

namespace App\Livewire\Economate;

use App\Models\Provider;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ProviderComponent extends Component
{
    use LivewireAlert;
    public $name,$phone,$alternativephone,$email,$nif,$address,$type,$edit,$search;
    protected $listeners= ['delete'=>'delete','close'=>'close'];
    protected $rules =  [
        'name'=>'required',
        'phone'=>'required',
        'email'=>'required|unique:providers,email',
        'nif'=>'required',
        'type'=>'required',
        'address'=>'required',
    ];
    protected $messages = [
        'name.required'=>'Obrigatório',
        'phone.required'=>'Obrigatório',
        'email.required'=>'Obrigatório',
        'email.unique'=>'Já existe',
        'nif.required'=>'Obrigatório',
        'type.required'=>'Obrigatório',
        'address.required'=>'Obrigatório',
    ];
    public function render()
    {
        return view('livewire.economate.provider-component',[
            'providers'=>$this->searchProviders($this->search)
        ])->layout('layouts.economate.app');
    }


       //Salvar Categoria
       public function save()
       {
           $this->validate($this->rules,$this->messages);
           try {
             
   
               Provider::create([
                'name'=>$this->name,
                'phone'=>$this->phone,
                'alternativephone'=>$this->alternativephone,
                'email'=>$this->email,
                'nif'=>$this->nif,
                'address'=>$this->address,
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
       //Editar Fornecedor
       public function editProvider($id)
       {
           
          
           try {
              
               $provider = Provider::find($id);
               $this->name = $provider->name;
               $this->phone = $provider->phone;
               $this->alternativephone = $provider->alternativephone;
               $this->email = $provider->email;
               $this->nif = $provider->nif;
               $this->address = $provider->address;
               $this->type = $provider->type;
               $this->edit = $provider->id;
               
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
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required|unique:providers,email,'.$this->edit,
            'nif'=>'required',
            'type'=>'required',
            'address'=>'required',
           ],$this->messages);
          
           try {
              
            
           Provider::find($this->edit)->update([
               'name'=>$this->name,
               'phone'=>$this->phone,
               'alternativephone'=>$this->alternativephone,
               'email'=>$this->email,
               'nif'=>$this->nif,
               'address'=>$this->address,
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
            dd($th->getMessage());
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
              
               Provider::destroy($this->edit);
              
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
       public function searchProviders($search)
       {
           try {
   
               if($search != null)
               {
                   return Provider::where('company_id','=',auth()->user()->company_id)->where('name','like','%'.$search.'%')->latest()->get();
               }else{
                   return Provider::where('company_id','=',auth()->user()->company_id)->latest()->get();
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
        $this->name = '';
        $this->phone = '';
        $this->alternativephone = '';
        $this->email = '';
        $this->nif = '';
        $this->address = '';
        $this->type = '';
       }


}
