<?php

namespace App\Livewire\Client;

use App\Models\ClientLocal;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ReviewComponent extends Component
{
    use LivewireAlert;
    public $stars = 1,$comment;
    public function render()
    {
        return view('livewire.client.review-component')->layout('layouts.review.app');
    }


    public function saveReview()
    {
        try {
            $currentUser = User::destroy(session('currentuser'));
            $forcedelete = User::onlyTrashed()->find(session('currentuser'));
            if ($forcedelete != null) {
                # code...
                $forcedelete->forceDelete();
                ClientLocal::where('user_id','=',session('currentuser'))->delete();
                
                Review::create([
                    "star_number"=>$this->stars,
                    "comment"=>$this->comment,
                ]);
               
    
                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'A sua avaliação foi recebida'
                ]);
                return  response()->download(storage_path().'/app/public/receipts/'.date('H').'fatura.pdf');
            }

                  session()->forget('finallyOrder');
            return redirect()->route('client.home');
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


    public function redirectUser()
    {
        try {
            $currentUser = User::destroy(session('currentuser'));
            $forcedelete = User::onlyTrashed()->find(session('currentuser'));
            $forcedelete->forceDelete();
            ClientLocal::where('user_id','=',session('currentuser'))->delete();
            if ($forcedelete != null) {
                return  response()->download(storage_path().'/app/public/receipts/'.date('H').'fatura.pdf');
            }

            return redirect()->route('site.home');
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
