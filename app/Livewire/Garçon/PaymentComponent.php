<?php

namespace App\Livewire\Garçon;

use App\Api\FactPlus;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\{
    BankAccount,
    CartLocal,
    CartLocalDetail,
    Table,
    ClientLocal,
    Company,
    DetailOrder,
     GarsonTable,
    Item,
    Order,
    OrderDetail
};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PaymentComponent extends Component
{
    use LivewireAlert;
   
    public $tableNumber,$selectchannel,$channel,$email, $paymenttype = 'Transferência',$payallaccount = 'Pagar Toda Conta',$divisorresult,$totalOtherItems = 0,$totalDrinks = 0;
    public $total = 0,$firstvalue,$secondvalue,$orderid,$divisorresultvalue;
    protected $listeners = ['open-modal'=>'open-modal'];



    public function render()
    {
        return view('livewire.garson.payment-component',[
            'allTables'=>$this->getTable(),
            'bankAccounts'=>$this->getBankAccount()
        ])->layout('layouts.garson.app');
    }


    public function getBankAccount()
    {
        try {
           return BankAccount::where('company_id','=',auth()->user()->company_id)
            ->where('status','=','1')
            ->limit(3)
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
    

    public function getTotal()
    {
        try {
            $this->total = 0;
            $this->totalOtherItems = 0;
            $this->totalDrinks = 0;

            $listDrinksTotal = CartLocal::join('cart_local_details','cart_locals.id','cart_local_details.cart_local_id')
            ->select('cart_locals.id as cartlocalid','cart_local_details.id','cart_local_details.created_at','cart_local_details.name','cart_local_details.price','cart_local_details.quantity','cart_local_details.status')
            ->where('cart_locals.table','=',$this->tableNumber)
            ->where('cart_local_details.category','=','Bebidas')
            //->where('cart_local_details.status','<','RECEBIDO')
            ->where('cart_locals.company_id','=',auth()->user()->company_id)
            ->get();

            $listOtherItemsTotal = CartLocal::join('cart_local_details','cart_locals.id','cart_local_details.cart_local_id')
            ->select('cart_locals.id as cartlocalid','cart_local_details.id','cart_local_details.created_at','cart_local_details.name','cart_local_details.price','cart_local_details.quantity','cart_local_details.status')
            ->where('cart_locals.table','=',$this->tableNumber)
            ->where('cart_local_details.category','<>','Bebidas')
            //->where('cart_local_details.status','=','RECEBIDO')
            ->where('cart_locals.company_id','=',auth()->user()->company_id)
            ->get();

            if ($listOtherItemsTotal) {
                foreach ($listDrinksTotal as  $value) {
               
                    $this->totalOtherItems += ($value->price * $value->quantity);
                }
            }else{
                $this->totalOtherItems = 0;
            }
            
            if ($listDrinksTotal) {
            foreach ($listOtherItemsTotal as  $value) {
           
                $this->totalDrinks += ($value->price * $value->quantity);
            }

            }else{
                $this->totalDrinks = 0;
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
                     

            }elseif($this->payallaccount == 'Dividir-3')
            {
                
                $this->divisorresult = number_format((ceil($this->total / 3)),2,',','.');
            }else{
                    
                    $this->divisorresult = number_format((ceil($this->total / 4)),2,',','.');
                    $this->divisorresultvalue = ceil($this->total / 4);
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
            
        } else {
            $this->validate(['paymenttype'=>'required'],['paymenttype.required'=>'Obrigatório']);

        }

        if ($this->payallaccount != 'Pagar Toda Conta') {
            $this->validate(['divisorresult'=>'required'],['divisorresult.required'=>'Obrigatório']);
            
        } else {
            $this->validate(['payallaccount'=>'required'],['payallaccount.required'=>'Obrigatório']);

        }
         
        DB::beginTransaction();
         try {

          if ($this->total == 0) {
            $this->alert('warning', 'AVISO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Não pode anotar pagamento em uma mesa sem pedidos ou com total negativo'
            ]);
          }else{

            if ($this->firstvalue != null and $this->secondvalue !=null) {
                
                if ($this->total != ($this->firstvalue + $this->secondvalue)) {

                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Os valores de diferentes tipos de pagamento não correspondem ao total.'
                    ]);


                    return;

                }
            }

              //Pegar todos os dados necessarios para finalizar pagamento
              
            $cartLocal =  CartLocal::where('user_id','=',auth()->user()->id)
            ->where('company_id','=',auth()->user()->company_id)
            ->first(); 
            if ($cartLocal) {
                # code...
                $cartLocalDetail =  CartLocalDetail::where('cart_local_id','=',$cartLocal->id)
                ->where('company_id','=',auth()->user()->company_id)
                ->get();

        
            $order = Order::create([
             'table'=>$cartLocal->table,
             'identify'=>auth()->user()->id,
             'user_id'=>auth()->user()->id,
             'paymenttype'=>$this->paymenttype,
             'splitAccount'=>$this->payallaccount,
             'firstvalue'=>$this->firstvalue,
             'secondvalue'=>$this->secondvalue,
             'divisorresult'=> floatval(preg_replace('/[^\d.]/', '', $this->divisorresult)),
             'total'=>$this->total,
             'status'=>'pago',
             'company_id'=>auth()->user()->company_id
            ]);

             if($cartLocalDetail->count() > 0)
             {
                 foreach ($cartLocalDetail as $item) {
                     DetailOrder::create([
                         'order_id'=>$order->id,
                         'item'=>$item->name,
                         'price'=>$item->price,
                         'quantity'=>$item->quantity,
                         'subtotal'=>$item->price * $item->quantity,
                         'company_id'=>auth()->user()->company_id
                     ]);

                     $itemFinded = Item::where('description','=',$item->name)->first();
                     $itemFinded->quantity -=$item->quantity;
                     $itemFinded->save();
                 }

             }
             
             $table = Table::where('number','=',$this->tableNumber)
             ->where('company_id','=',auth()->user()->company_id)
             ->first();

             if($table){
                 
                $table->status = 0;
                $table->save();
                $this->orderid = $order->id;
                
            }

                //$reference = \App\Api\FactPlus::create($this->orderid);
                //session()->put('finallyOrder',$reference);
                session()->put('finallyOrder','actual');
                
         
          
            DB::commit();
        }else{
            $this->alert('warning', 'AVISO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'
                         O cliente que fez este pedido, ainda não realizou o pagamento,
                         Deve aguardar que o cliente 
                    '
            ]);
        }
        }
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




    public function sendReceipt()
    {
        
     
        
         try {
            
            
            //  $company = Company::find(auth()->user()->company_id);
              //FactPlus::changeStatu(session('finallyOrder'));
              //if($this->email != null)
             // {
                //$this->validate(['email'=>'email'],['email.email'=>'E-mail Inválido']);  
               // FactPlus::sendInvoice(session('finallyOrder'),$this->email);
             // }
             // FactPlus::sendInvoice(session('finallyOrder'),$company->companyemail);
              
              $this->clearFields();
              session()->forget('finallyOrder');
              return redirect()->route('garson.home');
                

            
           
 
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
           
            $cartLocalFinded =  CartLocal::where('user_id','=',auth()->user()->id)
            ->where('company_id','=',auth()->user()->company_id)
            ->first(); 
            $detail =  CartLocalDetail::where('cart_local_id','=',$cartLocalFinded->id)
            ->where('company_id','=',auth()->user()->company_id)
            ->delete(); 
            $cartLocalFinded->delete();

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


    public function getTable()
    {
        try {
           $garsontable =  GarsonTable::where('user_id','=',auth()->user()->id)
           ->where('status','=','Turno Aberto')
            ->where('company_id','=',auth()->user()->company_id)
            ->get();



            if($garsontable)
            {
               return $garsontable;
            }else{
                return [];
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
