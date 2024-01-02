<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\StockEnter;
use App\Models\StockOut;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

 class  StockOutExport  implements FromQuery, WithHeadings
{
    use Exportable;
    protected $start,$end;
    public function __construct($start = null,$end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public  function query()
    {

        try {
          
        
        if ($this->start != null || $this->end != null) {
 
                      
            return StockOut::query()->join('product_economates','product_economates.id','stock_outs.product_economate_id')
            ->join('companies','companies.id','stock_outs.company_id')
            ->select('companies.companyname','stock_outs.created_at','product_economates.description','stock_outs.quantity','stock_outs.usetype','stock_outs.unit','stock_outs.chef','stock_outs.from','stock_outs.to')
            ->where('stock_outs.company_id','=',auth()->user()->company_id)
            ->whereBetween('stock_outs.created_at',[$this->start,$this->end]);
 
            

        } else {
          
            return StockOut::query()->join('product_economates','product_economates.id','stock_outs.product_economate_id')
            ->join('companies','companies.id','stock_outs.company_id')
            ->select('companies.companyname','stock_outs.created_at','product_economates.description','stock_outs.quantity','stock_outs.usetype','stock_outs.unit','stock_outs.chef','stock_outs.from','stock_outs.to')
            ->where('stock_outs.company_id','=',auth()->user()->company_id);
 
        }

    } catch (\Throwable $th) {
      return ;
    }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Data','Item','Quantidade','Utilização','Unidade','Responsável','Origem','Destino'];
    }

   
    
   
    

}