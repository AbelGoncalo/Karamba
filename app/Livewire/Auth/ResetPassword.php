<?php

namespace App\Livewire\Auth;

use App\Mail\ResetPassword as MailResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ResetPassword extends Component
{
    use LivewireAlert;
    public $email;
    public function render()
    {
        return view('livewire.auth.reset-password')
        ->layout('layouts.auth.app');
    }


    public function resetPassword()
    {
        $this->validate(['email'=>'required|email'],['email.required'=>'Campo obrigatório','email.email'=>'Informe um e-mail válido']);
        try {

            $userFinded = User::where('email','=',$this->email)->first();


            if ($userFinded) {

                $newPasswordRandom = rand(10000,50000);
                $incriptPassword = Hash::make($newPasswordRandom);

                $userFinded->password = $incriptPassword;
                $userFinded->save();


                if ($userFinded) {
                    Mail::to($userFinded->email)->send(new MailResetPassword($newPasswordRandom));

                    $this->alert('success', 'SUCESSO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'time'=>5000,
                        'text'=>'Verifique seu email, foi enviado a sua nova senha de acesso.'
                    ]);
                }else{
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Falha ao recuperar senha.'
                    ]);
                }



            } else {
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Não existe uma conta associada a este email.'
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
