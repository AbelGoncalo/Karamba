<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\{User,Category, Delivery, Item,Order};
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HomeComponent extends Component
{
    use LivewireAlert;
    public $monthOrder = [],$monthOrderCount = [],$deliveryMonth = [], $deliveryMonthCount = [];
         

    //  // Metodo para alimentar o grafico
     public function OrderChart(){

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
     // Metodo para alimentar o grafico
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


    public function render()
    {
    
        return view('livewire.admin.home-component',[
            'categories'=>Category::where('company_id','=',auth()->user()->company_id)->count(),
            'users'=>User::where('profile','<>','administrador')->where('profile','<>','client-local')->count(),
            'items'=>Item::where('company_id','=',auth()->user()->company_id)->count(),
            'order'=>Order::where('company_id','=',auth()->user()->company_id)->count(),
            'orderToday'=>Order::whereBetween('created_at',[date('Y-m-d ').'00:00:00',date('Y-m-d ').'23:59:59'])
            ->where('company_id','=',auth()->user()->company_id)
            ->count(),
            "deliveryChart"=>$this->deliveryChart(),
            "orderChart"=>$this->OrderChart(),
        ])->layout('layouts.admin.app');
    }



}
