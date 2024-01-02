<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\DetailOrder;
use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;


 class  OrderReportExport  implements FromQuery, WithHeadings
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

        
            
           return Order::query()->join('detail_orders','orders.id','detail_orders.order_id')
           ->join('companies','companies.id','orders.company_id')
           ->select('companies.companyname','detail_orders.item','detail_orders.price','detail_orders.quantity','detail_orders.tax','detail_orders.discount','detail_orders.subtotal')
           ->where('orders.company_id','=',auth()->user()->company_id)
            ->whereBetween('orders.created_at',[$this->start,$this->end]);
            

        } else {
          
            return Order::query()->join('detail_orders','orders.id','detail_orders.order_id')
            ->join('companies','companies.id','orders.company_id')
            ->select('companies.companyname','detail_orders.item','detail_orders.price','detail_orders.quantity','detail_orders.tax','detail_orders.discount','detail_orders.subtotal')
            ->where('orders.company_id','=',auth()->user()->company_id);
 
        }

    } catch (\Throwable $th) {
      return ;
    }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Item','Preço','Quantidade','Taxa','Desconto','Total'];
    }

    

}