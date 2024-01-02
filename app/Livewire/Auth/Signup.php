<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\{Company, User};
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Signup extends Component
{
    use LivewireAlert;
    public $name,$lastname,$email,$password,$cpassword,$acceptterms,$phone,$companyid;
    protected $rules =[
        'name'=>'required',
        'lastname'=>'required',
        'email'=>'required|unique:users,email|email',
        'password'=>'required',
        'cpassword'=>'required|same:password',
        'acceptterms'=>'required',
        'companyid'=>'required'
    ];
    protected $messages =[
        'name.required'=>'Obrigatório',
        'companyid.required'=>'Obrigatório',
        'lastname.required'=>'Obrigatório',
        'email.required'=>'Obrigatório',
        'acceptterms.required'=>'Obrigatório',
        'email.unique'=>'Já existe uma conta com este email',
        'email.email'=>'E-mail inválido',
        'password.required'=>'Obrigatório',
        'cpassword.required'=>'Obrigatório',
        'cpassword.same'=>'Senhas não coincidem'
    ];
  



    public function createAccount()
    {
        
        $this->validate($this->rules,$this->messages);
        try {

           
            User::create([
                'name'=>$this->name,
                'lastname'=>$this->lastname,
                'phone'=>$this->phone,
                'profile'=>'client',
                'status'=>'1',
                'email'=>$this->email,
                'password'=>$this->password,
                'acceptterms'=>$this->acceptterms,
                'company_id'=>$this->companyid,
            ]);

            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);

            return redirect()->route('auth.login');

        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Erro ao realizar operação'
            ]);
        }
    }
    public function render()
    {
        return view('livewire.auth.signup',[
            'companies'=>Company::get()
        ])->layout('layouts.auth.app');
    }
}
