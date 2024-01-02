<?php

namespace App\Livewire\Treasury;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\{BankAccount, User,Category, Delivery, Item,Order,Customer,Saque};
use Jantinnerezo\LivewireAlert\LivewireAlert;



class HomeComponent extends Component

{   

    use LivewireAlert;
    public $monthDebit = [],$monthDebitCount = [];
    public $deliveryMonth = [],$deliveryMonthCount = [];
    public $monthOrder = [],$monthOrderCount = [];


    //  // Metodo para alimentar o grafico do saques
    public function debitChart(){

        $debits = Saque::select('id','created_at')
        ->where('company_id',"=",auth()->user()->company_id)
        ->get()->groupBy(function($data){
            return   \Carbon\Carbon::parse($data->created_at)->format('M');
        });

       
        foreach($debits as $month => $values){
            $this->monthDebit[] = $month;
            $this->monthDebitCount[] = count($values);
        }

    }
    // Metodo para alimentar o grafico de encomenda
    public function deliveryChart(){
      
       $deliveries = Delivery::select('id','created_at')
       ->where('company_id',"=",auth()->user()->company_id)
       ->get()->groupBy(function($data){
           return   \Carbon\Carbon::parse($data->created_at)->format('M');
       });

       
       foreach($deliveries as $month => $values){
        
           $this->deliveryMonth[] = $month;
           $this->deliveryMonthCount[] = count($values);
       }
       
     
   }


   public function orderChart(){

    $orders = Order::select('id','created_at')
    ->where('company_id',"=",auth()->user()->company_id)
    ->get()->groupBy(function($data){
        return   \Carbon\Carbon::parse($data->created_at)->format('M');
    });


    
    foreach($orders as $month => $values){
        $this->monthOrder[] = $month;
        $this->monthOrderCount[] = count($values);
    }


}


    public function render()
    {
        $initialdate = Carbon::parse()->format('Y-m-d') .' 00:00:00';

        $enddate   = Carbon::parse()->format('Y-m-d') .' 23:59:59';

        return view('livewire.treasury.home-component',[
            'banks'=>BankAccount::where('company_id','=',auth()->user()->company_id)->count() ?? '0',
            'saques'=>Saque::where('company_id','=',auth()->user()->company_id)->count() ?? '0',
            'saquetoday'=>Saque::whereDate('created_at',today())
            ->where('company_id','=',auth()->user()->company_id)
            ->count() ?? '0',
            "deliveryChart"=>$this->deliveryChart(),
            "orderChart"=>$this->OrderChart(),
            "debitChart"=>$this->debitChart(),

        ])->layout('layouts.treasury.app');
    }

}
