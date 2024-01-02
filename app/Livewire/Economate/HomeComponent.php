<?php

namespace App\Livewire\Economate;

use App\Livewire\Admin\CategoryComponent;
use App\Models\CategoryEconomate;
use App\Models\ProductEconomate;
use App\Models\Provider;
use App\Models\StockEnter;
use App\Models\StockOut;
use Livewire\Component;

class HomeComponent extends Component
{

    public  $monthStockEnter = [],$monthStockEnterCount = [];

    public function render()
    {
       
        return view('livewire.economate.home-component',[
            'products'=>ProductEconomate::where('company_id','=',auth()->user()->company_id)->count(),
            'categories'=>CategoryEconomate::where('company_id','=',auth()->user()->company_id)->count(),
            'stockentertoday'=>StockEnter::where('company_id','=',auth()->user()->company_id)
                ->whereDate('created_at','=',today())->count(),
            'stockouttoday'=>StockOut::where('company_id','=',auth()->user()->company_id)
                ->whereDate('created_at','=',today())->count(),
                'chartStockEnter'=>$this->stockEnterChart()
        ])->layout('layouts.economate.app');
    }


      //  // Metodo para alimentar o grafico
      public function stockEnterChart(){

        $stock = StockEnter::select('id','created_at')
        ->where('company_id',"=",auth()->user()->company_id)
        ->get()->groupBy(function($data){
            return   \Carbon\Carbon::parse($data->created_at)->format('M');
        });

    

        foreach($stock as $month => $values){
            $this->monthStockEnter[] = $month;
            $this->monthStockEnterCount[] = count($values);
        }

    }
}
