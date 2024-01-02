<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Saque;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

 class  DebitReportExport  implements FromQuery, WithHeadings
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

        
            
           return Saque::query()
           ->join('companies','companies.id','saques.company_id')
           ->join('users','users.id','saques.user_id')
           ->select('companies.companyname','users.name','users.lastname','saques.value','saques.description','saques.date')
           ->where('saques.company_id','=',auth()->user()->company_id)
            ->whereBetween('saques.created_at',[$this->start,$this->end]);
            

        } else {
          
           return Saque::query()
            ->join('companies','companies.id','saques.company_id')
            ->join('users','users.id','saques.user_id')
            ->select('companies.companyname','users.name','users.lastname','saques.value','saques.description','saques.date')
            ->where('saques.company_id','=',auth()->user()->company_id);
 
        }

    } catch (\Throwable $th) {
      return ;
    }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Nome Usuário','Sobrenome Usuário','Valor','Descrição','Data'];
    }

   
    
   
    

}