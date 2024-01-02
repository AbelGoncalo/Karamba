<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\{Table,ClientLocal, Company, User};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HomeComponent extends Component
{
    use LivewireAlert;
    public $tableNumber, $clientName,$clientCount,$company; 
    protected $rules = ['tableNumber'=>'required','company'=>'required'];
    protected $messages = ['tableNumber.required'=>'Preencha o campo, porfavor','company.required'=>'Informe o código do restaurante'];

        public function mount()
        {
            $this->clientCount = 1;
        }
    
    public function render()
    {
        
      return view('livewire.client.home-component',[
        'companies'=>Company::get()
      ])->layout('layouts.client.app');

        
    }


    public function createSession()
    {
        
        $this->validate($this->rules,$this->messages);
        try {

            $number = 'Mesa '.$this->tableNumber;
            $company = Company::find($this->company);
          
            $table = Table::where('number','=',$number)
            ->where('company_id','=',$company->id)
            ->first();
               
            if($table)
            {
                if($table->status == 0){

                   

                    $createuser =  User::create([
                        'name'=>'Clinte-Local',
                        'lastname'=>'Local-Local',
                        'profile'=>'client-local',
                        'status'=>'1',
                        'email'=>'clientelocal'.rand().'-'.date('H:i').'@gmail.com',
                        'password'=>Hash::make($table),
                        'acceptterms'=>'1',
                        'company_id'=>$company->id
                     ]);

                     $client =  ClientLocal::create([
                        'client'=>$this->clientName ?? 'XXXXXXXXX',
                        'tableNumber'=>$number,
                        'clientCount'=>$this->clientCount,
                        'user_id'=>$createuser->id,
                        'company_id'=>$company->id
                        
                    ]);

                     $table->status = 1;
                     $table->save();

                   
                     $credentials = ['email' => $createuser->email, 'password' => $table];

                    if (Auth::attempt($credentials)) {

                        return redirect()->route('client.orders');

                    } else{
                        $this->alert('warning', 'AVISO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Algo correu mal'
                        ]); 
                    }

                    
                }else{
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Não pode fazer pedidos para uma mesa já ocupada'
                    ]); 
                }
            }else{
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Porfavor, verifique se informou o número da mesa correctamente!!'
                ]);
            }

            
            
        } catch (\Exception $th) {
            
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);

        }
    }


    public function logout()
    {
        try {
            //code...
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
