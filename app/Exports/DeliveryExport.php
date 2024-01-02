<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\DetailOrder;
use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

 class  DeliveryExport  implements FromQuery, WithHeadings
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

        
            
           return Delivery::query()->join('delivery_details','deliveries.id','delivery_details.delivery_id')
           ->join('companies','companies.id','deliveries.company_id')
           ->select('companies.companyname','delivery_details.item','delivery_details.price','delivery_details.quantity','delivery_details.tax','delivery_details.discount','delivery_details.subtotal','deliveries.customerpaymenttype')
           ->where('deliveries.company_id','=',auth()->user()->company_id)
            ->whereBetween('deliveries.created_at',[$this->start,$this->end]);
            

        } else {
          
            return Delivery::query()->join('delivery_details','deliveries.id','delivery_details.delivery_id')
            ->join('companies','companies.id','deliveries.company_id')
            ->select('companies.companyname','delivery_details.item','delivery_details.price','delivery_details.quantity','delivery_details.tax','delivery_details.discount','delivery_details.subtotal','deliveries.customerpaymenttype')
            ->where('deliveries.company_id','=',auth()->user()->company_id)
            ->whereBetween('deliveries.created_at',[date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59'])    
            ->where('orders.company_id','=',auth()->user()->company_id);
 
        }

    } catch (\Throwable $th) {
      return ;
    }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Item','Preço','Quantidade','Taxa','Desconto','Total','Forma de Pagamento'];
    }

   
    
   
    

}