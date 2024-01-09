<?php

namespace App\Livewire\Garson;

use App\Api\FactPlus;
use App\Jobs\FactPlusJob;
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
    HistoryOfAllActivities,
    Item,
    Order,
    OrderDetail,
};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PaymentComponent extends Component
{
    use LivewireAlert;
   
    public $tableNumber,$selectchannel,$channel,$email, $paymenttype = 'Transferência',$payallaccount = 'Pagar Toda Conta',$divisorresult,$totalOtherItems = 0,$totalDrinks = 0;
    public $total = 0,$firstvalue,$secondvalue,$orderid,$divisorresultvalue,$name,$nif,$address;
    protected $listeners = ['reload'=>'reload'];



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

            $listTotal = CartLocalDetail::where('table','=',$this->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
            ->get();

             
 
            
            if ($listTotal) {
            foreach ($listTotal as  $value) {
           
                $this->total += ($value->price * $value->quantity);
            }

            }else{
                $this->total = 0;
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
        
       
      
        //DB::beginTransaction();
       #Validação de campos
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
         
       #Fim de Validação de campos
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
              
           
            $cartLocalDetail =  CartLocalDetail::where('table','=',$this->tableNumber)
            ->where('company_id','=',auth()->user()->company_id)
            ->get();
            if ($cartLocalDetail) {
        
            $order = Order::create([
             'table'=>$this->tableNumber,
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


                     
                     //Registar o log de pagamentos
                    $log  = new HistoryOfAllActivities();
                    $log->tipo_acao = "Finalizacao de pagamento";
                    $log->responsavel = auth()->user()->name;
                    $log->descricao = 'O garson '.auth()->user()->name. 'Finalizou o pagamento de '.$item->name. ' no valor de '. $item->price.'KZS'. ' com o subtotal de '.$item->price * $item->quantity.'KZS';
                    $log->save();


                                    
                   
                   
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

            
                

        $reference =    \App\Api\FactPlus::create($order->id,$this->name,$this->nif,$this->address);
        
        \App\Api\FactPlus::changeStatu($reference,'sent');

            session()->put('finallyOrder',$reference);
            session()->put('table',$this->tableNumber);
            
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

        //DB::commit();
        
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

           
            
              
             
              $this->clearFields();
             \App\Api\FactPlus::sendInvoice(session('finallyOrder'),$this->email);
              session()->forget('finallyOrder');
              session()->forget('table');

              $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Pagamento finalizado com sucesso'
            ]);


            $this->dispatch('reralod');
           
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

         
             CartLocalDetail::where('table','=',session('table'))
            ->where('company_id','=',1)
            ->delete();


           

            $this->paymenttype = 'Transferência';
            $this->payallaccount = 'Pagar Toda Conta';
            $this->divisorresult = '';
            $this->totalOtherItems = 0;
            $this->totalDrinks = 0;
            $this->total = 0;
            $this->firstvalue = '';
            $this->secondvalue = '';
            $this->nif = '';
            $this->name = '';
           

           
            
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
