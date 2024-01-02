<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\StockEnter;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

 class  StockEnterExport  implements FromQuery, WithHeadings
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

        
                      
            return StockEnter::query()->join('product_economates','product_economates.id','stock_enters.product_economate_id')
            ->join('companies','companies.id','stock_enters.company_id')
            ->select('companies.companyname','stock_enters.created_at','stock_enters.expiratedate','product_economates.description','stock_enters.unit','stock_enters.source_product','stock_enters.source','stock_enters.price','stock_enters.unit_price','stock_enters.quantity')
            ->where('stock_enters.company_id','=',auth()->user()->company_id)
            ->whereBetween('stock_enters.created_at',[$this->start,$this->end]);
 
            

        } else {
          
           return  StockEnter::query()->join('product_economates','product_economates.id','stock_enters.product_economate_id')
            ->join('companies','companies.id','stock_enters.company_id')
            ->select('companies.companyname','stock_enters.created_at','stock_enters.expiratedate','product_economates.description','stock_enters.unit','stock_enters.source_product','stock_enters.source','stock_enters.price','stock_enters.unit_price','stock_enters.quantity')
            ->where('stock_enters.company_id','=',auth()->user()->company_id);
 
        }

    } catch (\Throwable $th) {
      return ;
    }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Data','Validade','Item','Unidade','Origem do Produto','Fonte','Preço','Preço Unitário','Quantidade'];
    }

   
    
   
    

}