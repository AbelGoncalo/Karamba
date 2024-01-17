<?php

namespace App\Livewire\Treasury;

use App\Models\HistoryOfAllActivities;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

use Jantinnerezo\LivewireAlert\LivewireAlert;
class MyAccount extends Component
{
    use LivewireAlert;
    public $name,$lastname,$email,$phone,$password,$npassword,$cpassword,$edit;
    protected $listeners = ['confirmed'=>'confirmed'];

    public function render()
    {
        return view('livewire.treasury.my-account')->layout('layouts.treasury.app');
    }

   

    public function validateFields($id = null)
    {
         $rules = [
            'name'=>'required',
            'lastname'=>'required',
            'email'=>'required|unique:users,email,'.$id,
        ];
          $messages = [
            'name.required'=>'Obrigatório',
            'lastname.required'=>'Obrigatório',
            'email.required'=>'Obrigatório',
        ];
      return  $this->validate($rules,$messages);
    }
    public function mount()
    {
        try {
            $this->name = auth()->user()->name;
            $this->lastname = auth()->user()->lastname;
            $this->email = auth()->user()->email;
            $this->phone = auth()->user()->phone;

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

    public function updateAccount()
    {
        $this->validateFields(auth()->user()->id);
        try {

            User::find(auth()->user()->id)->update([
                'name'=>$this->name,
                'lastname'=>$this->lastname,
                'email'=>$this->email,
                'phone'=>$this->phone,
            ]);

             //Log de actividades para atualização da conta
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Atualizar dados da conta';
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Tesoureiro '. auth()->user()->name.' '.auth()->user()->lastname.' atualizou os dados da sua conta para '
             .'Nome: '.$this->name.' '.$this->lastname.' Email: '.$this->email;
             $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
             $log->save();

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
    public function updatePassword()
    {
         $this->validate([
            'password'=>'required',
            'npassword'=>'required',
            'cpassword'=>'required|same:npassword',
        ],[
            
            'password.required'=>'Obrigatório',
            'npassword.required'=>'Obrigatório',
            'cpassword.required'=>'Obrigatório',
            'cpassword.same'=>'Senhas diferentes',
        ]);
        try {

            if (Hash::check($this->password,auth()->user()->password)) {
                
                User::find(auth()->user()->id)->update([
                    'password'=>$this->npassword,
                ]);
                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Perfil Actualizado'
                ]);
                $this->password = '';
                $this->npassword = '';
                $this->cpassword = '';
            }else{
                
                $this->alert('error', 'ERRO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Senha Actual inválida'
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
}

