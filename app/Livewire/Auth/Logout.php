<?php

namespace App\Livewire\Auth;

use App\Models\CartLocal;
use App\Models\CartLocalDetail;
use App\Models\ClientLocal;
use App\Models\GarsonTable;
use App\Models\HistoryOfAllActivities;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Logout extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view('livewire.auth.logout');
    }

    public function logout()
    {
        try {

        if (auth()->user()->profile === 'garçon') {
               
                     $garsontable  =  GarsonTable::where('user_id','=',auth()->user()->id)
                     ->where('company_id','=',auth()->user()->company_id)
                     ->where('user_id','=',auth()->user()->id)
                     ->where('status','=','Turno Aberto')
                     ->first();
        
                    if($garsontable)
                    {
                        $this->alert('warning', 'Aviso', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Não pode terminar sessão com turno aberto! Porfavor feche o turno e tente novamente'
                        ]);
                    }else{

                    //Log de actividades para o término de sessão do Garçom
                    
                    $log = new HistoryOfAllActivities();
                    $log->tipo_acao = 'Termar sessão no sistema';
                    $log->company_id = auth()->user()->company_id;
                    $log->descricao = 'O Garçon '. auth()->user()->name.' '.auth()->user()->lastname.' terminou a sua sessão';
                    $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
                    $log->save();
             
                        Auth::logout();
                        return redirect()->route('auth.logout');
                    }
                    
            

                    
                }else{

                    $log = new HistoryOfAllActivities();
                    $log->tipo_acao = 'Termar sessão no sistema';
                    $log->company_id = auth()->user()->company_id;
                    $log->descricao = 'O Utilizador '. auth()->user()->name.' '.auth()->user()->lastname.' terminou a sua sessão';
                    $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
                    $log->save();
                    
                    Auth::logout();
                    return redirect()->route('auth.logout');
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
