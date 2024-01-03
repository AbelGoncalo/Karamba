<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\{BankAccount, CartLocal,CartLocalDetail,ClientLocal, DetailOrder, GarsonTable, GarsonTableManagement, Item, NotificationGarson, Order,OrderDetail, Table, User};
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class PaymentComponent extends Component
{
    use LivewireAlert,WithFileUploads;
    public $realvalue, $paymenttype = 'Transferência',$payallaccount = 'Pagar Toda Conta',
    $divisorresult,$totalOtherItems = 0,$totalDrinks = 0,$orderfinded = [],$file_receipt;

    public $total = 0,$firstvalue,$secondvalue,$selectchannel,$channel,$email,$order_veriry;
    protected $listeners = ['open-modal'=>'open-modal','destroy-storage'=>'destroy-storage'];

    public function render()
    {
        
        return view('livewire.client.payment-component',[
            'bankAccounts'=>BankAccount::where('company_id','=',auth()->user()->company_id)
                            ->where('status','=','1')
                            ->limit(3)
                            ->get()
        ])->layout('layouts.client.app');
    }

    
    public function mount()
    {   
        try {
            $clientelocal = ClientLocal::where('user_id','=',auth()->user()->id)->first();

            $listDrinksTotal =  CartLocalDetail::where('category','=','Bebidas')
            ->where('table','=',$clientelocal->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
            ->get();
           


            $listOtherItemsTotal =  CartLocalDetail::where('category','<>','Bebidas')
            ->where('table','=',$clientelocal->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
            ->get();
            
            foreach ($listDrinksTotal as  $value) {
           
                $this->totalOtherItems += ($value->price * $value->quantity);
            }

            foreach ($listOtherItemsTotal as  $value) {
           
                $this->totalDrinks += ($value->price * $value->quantity);
            }

            $this->total =  $this->totalOtherItems + $this->totalDrinks;

          

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


    //Fazer calculo de divisão de pagamento
    public function divisor()
    {
        
        try {

            if($this->payallaccount == 'Dividir-2')
            {
                    $this->divisorresult = number_format((ceil($this->total / 2)),2,',','.');
                     
                    $this->realvalue = $this->total ;

            }elseif($this->payallaccount == 'Dividir-3')
            {
                $this->divisorresult = number_format((ceil($this->total / 3)),2,',','.');
                $this->realvalue = $this->total ;
                
            }else{
                
                $this->divisorresult = number_format((ceil($this->total / 4)),2,',','.');
                $this->realvalue = $this->total ;
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

   


    //Metodo para finalizar Pagamento
    public function finallyPayment()
    {

        DB::beginTransaction();
       
        //Validação de campos
        if ($this->paymenttype == 'TPA' and $this->paymenttype == 'Transferência') {
          
         
            $this->validate(['firstvalue'=>'required','secondvalue'=>'required'],
            ['firstvalue.required'=>'Obrigatório','secondvalue.required'=>'Obrigatório']);

        } elseif($this->paymenttype == 'Transferência' and $this->paymenttype == 'TPA') {

            $this->validate(['firstvalue'=>'required','secondvalue'=>'required'],
            ['firstvalue.required'=>'Obrigatório','secondvalue.required'=>'Obrigatório']);
        }elseif($this->paymenttype == 'TPA' and $this->paymenttype == 'Numerário'){
            
            $this->validate(['firstvalue'=>'required','secondvalue'=>'required'],
            ['firstvalue.required'=>'Obrigatório','secondvalue.required'=>'Obrigatório']);

        }elseif($this->paymenttype == 'Numerário' and $this->paymenttype == 'Transferência'){
            
            $this->validate(['firstvalue'=>'required','secondvalue'=>'required'],
            ['firstvalue.required'=>'Obrigatório','secondvalue.required'=>'Obrigatório']);
        }

        if ($this->paymenttype == 'Numerário') {
          
           
            $this->validate(['paymenttype'=>'required'],['paymenttype.required'=>'Obrigatório']);

        }
       

        if ($this->paymenttype == 'Transferência') {
            $this->validate(['file_receipt'=>'required'],
            ['file_receipt.required'=>'Obrigatório']);
        } else {
            $this->validate(['paymenttype'=>'required'],['paymenttype.required'=>'Obrigatório']);

        }

        if ($this->payallaccount != 'Pagar Toda Conta') {
            $this->validate(['divisorresult'=>'required'],['divisorresult.required'=>'Obrigatório']);
            
        } else {
            $this->validate(['payallaccount'=>'required'],['payallaccount.required'=>'Obrigatório']);

        }
        //  DB::beginTransaction();
         try {

                
            if ($this->total == 0) {
                $this->alert('error', 'ERRO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Não pode finalizar um pagamento com o total nulo!'
                ]);
            }else{

           
                //Pegar todos os dados necessarios para finalizar pagamento
           $client =  ClientLocal::where('user_id','=',auth()->user()->id)->first(); 
           $cartLocal =  CartLocal::where('client_local_id','=',$client->id)->first(); 
           $cartLocalDetail =  CartLocalDetail::where('cart_local_id','=',$cartLocal->id)->get(); 
        

           $receiptString = '';
           if($this->file_receipt)
           {
               $receiptString = md5($this->file_receipt->getClientOriginalName()).'.'.
                        $this->file_receipt->getClientOriginalExtension();


                        $this->file_receipt->storeAs('/public/comprovativos_pagamentos_trans/',$receiptString);


           }
           
           $order = Order::create([
            'table'=>$cartLocal->table,
            'client'=>$client->client,
            'identify'=>$client->id,
            'paymenttype'=>$this->paymenttype,
            'splitAccount'=>$this->realvalue,
            'firstvalue'=>$this->firstvalue,
            'secondvalue'=>$this->secondvalue,
            'divisorresult'=>$this->realvalue,
            'total'=>$this->total,
            'status'=>'pendente',
            'file_receipt'=>$receiptString,
            'company_id'=>auth()->user()->company_id

           ]);

            if($cartLocalDetail->count() > 0)
            {
                foreach ($cartLocalDetail as $item) {
                    DetailOrder::create([
                        'order_id'=>$order->id,
                        'table'=>$cartLocal->table,
                        'item'=>$item->name,
                        'price'=>$item->price,
                        'quantity'=>$item->quantity,
                        'subtotal'=>$item->price * $item->quantity,
                    ]);

                    $itemFinded = Item::where('description','=',$item->name)->first();
                    $itemFinded->quantity -=$item->quantity;
                    $itemFinded->save();

                }

            }

           $tableupdate  =  Table::where('number','=',$client->tableNumber)->first();
           $tableupdate->status = 0;
           $tableupdate->save();

           //criar factura no factplus
          $reference = \App\Api\FactPlus::create($order->id);
       
          $tablegarsonmanagement = GarsonTableManagement::where('table','=',$client->tableNumber)->first();
            if ($tablegarsonmanagement) {
           
                
                NotificationGarson::create([
                    'garson_table_id'=>$tablegarsonmanagement->garsontable->id,
                    'title'=>'PAGAMENTO',
                    'tableNumber'=>$client->tableNumber,
                    'message'=>'UM PAGAMENTO FOI  REALIZADO. AGUARDANDO A CONFIRMAÇÃO....' ,
                    'status'=>'0',
                    'paymentid'=>$order->id,
                    'company_id'=>auth()->user()->company_id,
                ]);

                session()->put('finallyOrder',$order->id);
                $this->order_veriry = $order->id;
                $this->orderfinded = Order::find($order->id);

                
                $orderfinded = Order::find($order->id);
                $orderfinded->user_id = $tablegarsonmanagement->garsontable->user_id;
                $orderfinded->save();
 
            }
            
        }
        DB::commit();
         } catch (\Throwable $th) {
           DB::rollBack();
             $this->alert('error', 'ERRO', [
                 'toast'=>false,
                 'position'=>'center',
                 'showConfirmButton' => true,
                 'confirmButtonText' => 'OK',
                 'text'=>'Falha ao realizar operação'
                ]);
         }
    }


    public function verifyPaymentStatus($id)
    {
        try {
            $this->orderfinded = [];
            $this->alert('info', '', [
                'toast'=>false,
                'position'=>'center',
                'timer'=>1000,
                'timerProgressBar'=> true,
                'text'=>'A VERIFICAR ESTADO DE PAGAMENTO...'
            ]);
     
            
            $this->orderfinded = Order::find(session('finallyOrder'));
            
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

       
    public function sendReceipt()
    {

        $this->validate(['email'=>'required'],['email.required'=>'Obrigatório']);
        

         try {

            //Enviar factura para o email do cliente
            $order = Order::find(session('finallyOrder'));
            if($order){

                \App\Api\FactPlus::sendInvoice($order->reference,$this->email);
                $this->clearFields();
                return redirect()->route('client.review.services');

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

    public function clearFields()
    {
        try {

          
            $clientlocal = ClientLocal::where('user_id','=',auth()->user()->id)->first();
            $cartlocal = CartLocal::where('client_local_id','=',$clientlocal->id)->first();
            
            
            $detail =  CartLocalDetail::where('cart_local_id','=',$cartlocal->id)
            ->delete(); 
            $clientlocal->delete();
            $cartlocal->delete();
            session()->put('currentuser',auth()->user()->id);

            $this->paymenttype = 'Transferência';
            $this->payallaccount = 'Pagar Toda Conta';
            $this->divisorresult = '';
            $this->totalOtherItems = 0;
            $this->totalDrinks = 0;
            $this->total = 0;
            $this->firstvalue = '';
            $this->secondvalue = '';
       
            
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
