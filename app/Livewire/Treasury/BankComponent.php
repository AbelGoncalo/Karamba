<?php

namespace App\Livewire\Treasury;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use App\Models\{User,Category, Delivery, Item,Order,Customer,Company,BankAccount, HistoryOfAllActivities};

use Livewire\Component;

class BankComponent extends Component
{
    use LivewireAlert,WithFileUploads;

    protected $listeners = ['delete'=>'delete','changeStatus'=>'changeStatus','close'=>'close'];
    
    public $bank, $ibam,$number,$edit,$search;

    protected $rules = [
        'bank'=>'required',
        'ibam'=>'required',
        'number'=>'required',
        
    ];
    protected $messages = [
        'bank.required'=>'Obrigatório',
        'ibam.required'=>'Obrigatório',
        'number.required'=>'Obrigatório',
    ];

    public function render()
    {
       
        return view('livewire.treasury.bank-component',[
            'banks'=>$this->searchBankAccounts($this->search)
        ])->layout('layouts.treasury.app');
    }


    public function searchBankAccounts($search)
    {
        try {
           if ($search != null) {
               # code...
               return BankAccount::where('company_id','=',auth()->user()->company_id)
               ->where('bank','like','%'.$search.'%')
               ->get();
           } else {
           return BankAccount::where('company_id','=',auth()->user()->company_id)->get();
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


    //salvar clientes
    public function save(){

            $this->validate($this->rules,$this->messages);
        try{
    
            BankAccount::create([
                'bank' =>$this->bank,
                'ibam' =>$this->ibam,
                'number' =>$this->number,
                'company_id' =>auth()->user()->company_id,
             ]);

             //Log para o registo da conta bancária 
                $log = new HistoryOfAllActivities();
                $log->tipo_acao = 'Adicionar conta bancária';
                $log->company_id = auth()->user()->company_id;
                $log->descricao = 'O Tesoureiro '. auth()->user()->name.' adicionou a conta bancária ao sistema com os dados Banco: '.$this->bank.' ,IBAN: '.$this->ibam.' Número da conta: '.$this->number;
                $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
                $log->save();
                  


            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);
           

                $this->clear();
            }catch(\Throwable $th){
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


    //Editar banos, carregar dados
    public function editBank($id)
    {
        
       
        try {
           
            $bank = BankAccount::find($id);
          
            $this->edit = $bank->id;
            $this->bank = $bank->bank;
            $this->ibam = $bank->ibam;
            $this->number = $bank->number;
            
            
            
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



    //Update Clientes
    public function update()
    {
        $this->validate([
            'bank'=>'required',
            'ibam'=>'required',
            'number'=>'required',
            
        ],$this->messages);
       
        try {
           
            $customer = BankAccount::find($this->edit)->update([
                'bank' =>$this->bank,
                'ibam' =>$this->ibam,
                'number' =>$this->number,
                
            ]);

             //Log para o atualização dos dados  da conta bancária 
             $customer = BankAccount::find($this->edit);
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Atualização dos dados conta bancária';
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Tesoureiro '. auth()->user()->name.' atualizou os dados da conta bancária do sistema para os dados Banco: '.$customer->bank.' ,IBAN: '. $customer->ibam.' Número da conta: '. $customer->number;
             $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
             $log->save();
            
            $this->dispatch('close');
            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);
            $this->clear();
            $this->dispatch('close');

        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação update'
            ]);
        }
    }

    //excluir Usuarios
    public function delete()
    {
        try {
           
             //Log para o registo da conta bancária 
             $customer = BankAccount::find($this->edit);
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Excluir conta bancária';
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Tesoureiro '. auth()->user()->name.' excluiu a conta bancária do sistema com os dados Banco: '.$customer->bank.' ,IBAN: '. $customer->ibam.' Número da conta: '. $customer->number;
             $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
             $log->save();

            BankAccount::destroy($this->edit);
           
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

      //confirmar exclusao de  Bancos
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



    //Pesquisar bancos
    public function searchUsers($search)
    {
        try {
            
            
            if($search != null)
            {
                return BankAccount::where('name','like','%'.$search.'%')
                        ->where('profile','<>','admin')        
                        ->latest()
                        ->get();
            }else{
                return User::where('profile','<>','admin')        
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

    public function confirmChangeStatus($id)
    {
        
       
        try {
            $this->edit = $id;
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente mudar o estado dessa conta bancaria?",
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
    public function changeStatus()
    {
        try {
           $bank =  BankAccount::find($this->edit);
           if ($bank->status == 1) {
               # code...
               $bank->status = 0;
               $bank->save();
            } else {
                # code...
                $bank->status = 1;
                $bank->save();
           }
           
          
            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Estado Alterado.'
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

    public function clear()
    {
        try {
            $this->bank = '';
            $this->ibam = '';
            $this->number = '';
            $this->edit = '';
            $this->search = '';
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
