<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserComponent extends Component
{
    use LivewireAlert,WithFileUploads;
    public $name, $lastname,$genre,$phone,$email,$profile,$photo,$edit,$search; 
    protected $rules = [
        'name'=>'required',
        'lastname'=>'required',
        'genre'=>'required',
        'phone'=>'required',
        'profile'=>'required',
        'email'=>'required|unique:users,email',
    ];
    protected $messages = [
        'name.required'=>'Obrigatório',
        'lastname.required'=>'Obrigatório',
        'genre.required'=>'Obrigatório',
        'phone.required'=>'Obrigatório',
        'profile.required'=>'Obrigatório',
        'email.required'=>'Obrigatório',
        'email.unique'=>'Já está a ser usado.',
    ];
    protected $listeners = ['close'=>'close','delete'=>'delete','changeStatus'=>'changeStatus'];

    public function render()
    {
        return view('livewire.admin.user-component',[
            'users'=>$this->searchUsers($this->search)
        ])->layout('layouts.admin.app');
    }


    //Salvar Usuarios
    public function save()
    {
        try {
            $this->validate($this->rules,$this->messages);
            $photoString = '';
            if($this->photo)
            {
                $photoString = md5($this->photo->getClientOriginalName()).'.'.
                         $this->photo->getClientOriginalExtension();
                         $this->photo->storeAs('public/',$photoString);


            }

            User::create([
                'name' =>$this->name,
                'lastname' =>$this->lastname,
                'genre' =>$this->genre,
                'photo' =>$photoString,
                'phone' =>$this->phone,
                'profile' =>$this->profile,
                'email' =>$this->email,
                'company_id' =>auth()->user()->company_id,
                'password' =>Hash::make($this->email),
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
    //Editar Usuarios
    public function editUser($id)
    {
        
       
        try {
           
            $user = User::find($id);
            $this->edit = $user->id;
            $this->name = $user->name;
            $this->lastname = $user->lastname;
            $this->genre = $user->genre;
            $this->photo = $user->photo;
            $this->phone = $user->phone;
            $this->profile = $user->profile;
            $this->email = $user->email;

            
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
    //confirmar mudança de estado da conta  de  Usuarios
    public function confirmChangeStatus($id)
    {
        
       
        try {
            $this->edit = $id;
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente alterar o estado desta conta?",
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


    //Update Usuarios
    public function update()
    {
        $this->validate([
            'name'=>'required',
            'lastname'=>'required',
            'genre'=>'required',
            'phone'=>'required',
            'profile'=>'required',
            'email'=>'required|unique:users,email,'.$this->edit,
        ],$this->messages);
       
        try {
           

            if($this->photo and !is_string($this->photo))
            {
                $photoString = md5($this->photo->getClientOriginalName()).'.'.
                         $this->photo->getClientOriginalExtension();


                         $this->photo->storeAs('public/',$photoString);

            User::find($this->edit)->update([
                'name' =>$this->name,
                'lastname' =>$this->lastname,
                'genre' =>$this->genre,
                'photo' =>$photoString,
                'phone' =>$this->phone,
                'profile' =>$this->profile,
                'email' =>$this->email,
            ]);

            }else{
                User::find($this->edit)->update([
                    'name' =>$this->name,
                    'lastname' =>$this->lastname,
                    'genre' =>$this->genre,
                    'phone' =>$this->phone,
                    'profile' =>$this->profile,
                    'email' =>$this->email,
                ]);
            }


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
    
    //excluir Usuarios
    public function delete()
    {
       
       
        try {
           
            User::destroy($this->edit);
           
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
    //excluir Usuarios
    public function changeStatus()
    {
       
       
        try {
           
            $user  = User::find($this->edit);
            ($user->status == 1)? $user->status = 0 : $user->status = 1;
            $user->save();
           
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
    //Pesquisar Usuarios
    public function searchUsers($search)
    {
        try {
            
            
            if($search != null)
            {
                return User::where('name','like','%'.$search.'%')
                        ->where('profile','<>','administrador')        
                        ->where('profile','<>','client-local')   
                        ->where('profile','<>','client')
                        ->where('profile','<>','super-admin')
                        ->where('company_id','=',auth()->user()->company_id)
                        ->latest()
                        ->get();
            }else{
                return User::where('profile','<>','administrador')  
                             ->where('profile','<>','client-local')        
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


    //Limpar campos
    public function clear()
    {
        $this->name = '';
        $this->lastname = '';
        $this->genre = '';
        $this->phone = '';
        $this->email = '';
        $this->profile = '';
        $this->edit = '';
        $this->search = '';
    }

}
