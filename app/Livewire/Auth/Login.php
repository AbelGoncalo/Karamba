<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Login extends Component
{
    use LivewireAlert;
    public  $email,$password,$remember;
    protected $rules = ['email'=>'required','password'=>'required'];
    protected $messages = ['email.required'=>'Obrigatório','password.required'=>'Obrigatório'];

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth.app');
    }




    public function login()
    {
        //$this->validate($this->rules,$this->messages);

        try {

            $user = User::where('email','=',$this->email)->first();

            if(!$user){
                $this->alert('error', 'ERRO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Não existe uma conta com este e-mail!!!'
                ]);

                return;
            }


            if($user->status == 1){
           

         
            if(Auth::attempt(['email' => $this->email, 'password' => $this->password],$this->remember)){

                if(auth()->user()->profile == 'administrador'){
                    
                    return redirect()->route('panel.admin.home');
                    
                }elseif(auth()->user()->profile == 'chef-de-sala'){

                    return redirect()->route('room.manager.home');

                }elseif(auth()->user()->profile == 'chefe-de-cozinha'){
                    
                    return redirect()->route('chefs.home');
                }elseif(auth()->user()->profile == 'garçon'){
                    
                    return redirect()->route('garson.home');

                }elseif(auth()->user()->profile == 'gestor-economato'){
                    
                    return redirect()->route('economate.panel.home');

                }elseif(auth()->user()->profile == 'client'){
                    
                    return redirect()->route('site.home');
                }elseif(auth()->user()->profile == 'tesoureiro'){

                     return redirect()->route('treasury.home');
                    
                }elseif(auth()->user()->profile == 'super-admin'){

                    return redirect()->route('control.panel.home');

                }elseif(auth()->user()->profile == 'barman'){

                    return redirect()->route('barman.home');
                }


            }else{
                $this->alert('error', 'ERRO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Credências Inválidas!!!'
                ]);
            }

        }else{

            $this->alert('warning', 'AVISO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Sua Conta foi Desativada, entre em contacto  com o Administrador do sistema'
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
