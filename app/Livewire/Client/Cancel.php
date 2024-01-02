<?php

namespace App\Livewire\Client;

use App\Models\CartLocal;
use App\Models\CartLocalDetail;
use App\Models\ClientLocal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Cancel extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view('livewire.client.cancel');
    }




    public function cancel()
    {
        try {
           
       
        //     $clientlocal =  ClientLocal::where('user_id','=',auth()->user()->id)->first();
        //     $cartlocal =  CartLocal::where('client_local_id','=',$clientlocal->id)->first();
            
        //    if (CartLocalDetail::where('client_local_id','=',$clientlocal->id)->count() > 0) {
        //       CartLocalDetail::where('client_local_id','=',$clientlocal->id)->delete();
        //       $clientlocal->delete();
        //       $cartlocal->delete();
        //       session()->put('clientid',auth()->user()->id);
        //        Auth::logout();
        //        User::find(session('clientid'))->delete();
        //    }else{

        //     $clientlocal->delete();
        //     $cartlocal->delete();
        //     session()->put('clientid',auth()->user()->id);
        //      Auth::logout();
        //      User::find(session('clientid'))->delete();
        //    }
        
        
        Auth::logout();
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
