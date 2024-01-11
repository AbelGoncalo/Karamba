<?php

namespace App\Livewire\Garson;

use App\Models\GarsonTable;
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
    public function render()
    {
        return view('livewire.garson.my-account',[
            'tables'=>$this->getTables()
        ])->layout('layouts.garson.app');
    }


    public function getTables()
    {
        try {

            return GarsonTable::where('user_id','=',auth()->user()->id)
            ->where('status','=','Turno Aberto')
            ->where('company_id','=',auth()->user()->company_id)
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

            //Log de alteração dos dados pessoais do Garçon
            $log = new HistoryOfAllActivities();
            $log->tipo_acao = 'Alteração de dados pessoais';
            $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
            $log->descricao = 'O Garçon '.auth()->user()->name.''.auth()->user()->lastname.'Alterou os dados pessoais da sua conta';
            $log->company_id = auth()->user()->company_id;
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


                //Log de alteração de senha do Garçon
                $log = new HistoryOfAllActivities();
                $log->tipo_acao = 'Alteração de senha';
                $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
                $log->descricao = 'O Garçon '.auth()->user()->name.''.auth()->user()->lastname.'alterou a sua senha';
                $log->company_id = auth()->user()->company_id;
                $log->save();
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

    public function confirm()
    {
        
       
        try {
         
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente fechar o turno? Não pode reverter a ação",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'OK',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'onConfirmed' => 'confirmed' 
            ]);

            //Log de fecho de turno do Grarçon
            $log = new HistoryOfAllActivities();
            $log->tipo_acao = 'Fecho de turno';
            $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
            $log->descricao = 'O Garçon '.auth()->user()->name.''.auth()->user()->lastname.' Fechou o seu turno';
            $log->company_id = auth()->user()->company_id;
            $log->save();
            
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
    public function confirmed()
    {
        
       
        try {
           
       
            $garsontable  =  GarsonTable::where('user_id','=',auth()->user()->id)
            ->where('company_id','=',auth()->user()->company_id)
            ->where('user_id','=',auth()->user()->id)
            ->where('status','=','Turno Aberto')
            ->get();

            if($garsontable)
            {

                foreach ($garsontable as $value) {
                    GarsonTable::find($value->id)->update([
                      'end' => date('Y-m-d'),
                       'endtime' => date('H:i'),
                       'status' => 'Turno Fechado'
                    ]);
                }

                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação realizada com sucesso'
                ]);
            }else{
                $this->alert('warning', 'Aviso', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Turno não encontrado'
                ]);
            }
            
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
}
