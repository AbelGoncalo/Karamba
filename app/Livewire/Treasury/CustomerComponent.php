<?php

namespace App\Livewire\Treasury;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\{User,Category, Delivery, Item,Order,Customer,Company};


class CustomerComponent extends Component
{

    use LivewireAlert,WithFileUploads;

    protected $listeners = ['delete'=>'delete'];
    
    public $name, $lastname,$genre,$phone,$email,$provincia,$municipio,$bairro, $rua,$edit,$search;
    
    protected $rules = [
        'name'=>'required',
        'lastname'=>'required',
        'genre'=>'required',
        'phone'=>'required',
        'provincia'=>'required',
        'municipio'=>'required',
        'bairo'=>'required',
        'rua'=>'required',
        'email'=>'required|unique:users,email',
    ];
    protected $messages = [
        'name.required'=>'Obrigatório',
        'lastname.required'=>'Obrigatório',
        'genre.required'=>'Obrigatório',
        'phone.required'=>'Obrigatório',
        'provincia.required'=>'Obrigatório',
        'email.required'=>'Obrigatório',
        'email.unique'=>'Já está a ser usado.',
    ];


    public function render()
    {
        return view('livewire.treasury.customer-component',[
           
            'customers'=>Customer::where('company_id','=',auth()->user()->company_id)->get(),
            'companies'=>Company::all(),

            
            ])->layout('layouts.treasury.app');
    }

    //salvar clientes
    public function save(){

        try{

            Customer::create([
                'name' =>$this->name,
                'lastname' =>$this->lastname,
                'genre' =>$this->genre,
                'phone' =>$this->phone,
                'provincia' =>$this->provincia,
                'municipio' =>$this->municipio,
                'bairro' =>$this->bairro,
                'rua' =>$this->rua,
                'email' =>$this->email,
                'company_id' =>auth()->user()->company_id,
            ]);
        }catch(\Throwable $th){
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


    //Editar clientes
    public function editUser($id)
    {
        
       
        try {
           
            $customer = Customer::find($id);
          
            $this->edit = $customer->id;
            $this->name = $customer->name;
            $this->lastname = $customer->lastname;
            $this->genre = $customer->genre;
            $this->phone = $customer->phone;
            $this->provincia = $customer->provincia;
            $this->municipio = $customer->municipio;
            $this->bairro = $customer->bairro;
            $this->rua = $customer->rua;
            $this->email = $customer->email;
            
            
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


    //Update Clientes
    public function update()
    {
        $this->validate([
            'name'=>'required',
            'lastname'=>'required',
            'genre'=>'required',
            'phone'=>'required',
            'provincia'=>'required',
            'municipio'=>'required',
            'bairro'=>'required',
            'rua'=>'required',
            'email'=>'required|unique:customers,email,'.$this->edit,
        ],$this->messages);
       
        try {
           
            $customer = Customer::find($this->edit)->update([
                'name' =>$this->name,
                'lastname' =>$this->lastname,
                'genre' =>$this->genre,
                'phone' =>$this->phone,
                'provincia' =>$this->provincia,
                'municipio' =>$this->municipio,
                'bairro' =>$this->bairro,
                'rua' =>$this->rua,
                'email' =>$this->email,
            ]);
            
            $this->dispatch('close');
            $this->alert('success', 'SUCESSO', [
                'toast'=>true,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);
            //$this->clear();

        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação update'
            ]);
        }
    }


    //excluir Usuarios
    public function delete()
    {
        try {
           
            Customer::destroy($this->edit);
           
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


    //Pesquisar clientes
    public function searchUsers($search)
    {
        try {
            
            
            if($search != null)
            {
                return Customer::where('name','like','%'.$search.'%')
                        ->where('profile','<>','admin')        
                        ->latest()
                        ->get();
            }else{
                return User::where('profile','<>','admin')        
                            ->latest()->get();
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
