<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;


 class  ReportRoomManagerExport  implements FromQuery, WithHeadings
{
    use Exportable;
    protected $startdate = null,$enddate = null,$searchByTable = null,$searchByGarson = null;
    public function __construct($startdate = null,$enddate = null,$searchByTable = null,$searchByGarson = null)
    {
        $this->startdate = $startdate;
        $this->enddate = $enddate;
        $this->searchByTable = $searchByTable;
        $this->searchByGarson = $searchByGarson;
        
    }

    public  function query()
    {

        try {
          
       
            if ($this->startdate != null and $this->enddate != null and $this->searchByTable != null and $this->searchByGarson != null)  {

                $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($this->enddate )->format('Y-m-d') .' 23:59:59';
                return Order::query()->where('user_id','=',$this->searchByGarson)
                        ->where('table','=',$this->searchByTable)
                        ->whereBetween('created_at',[$start,$end])
                        ->where('company_id','=',auth()->user()->company_id);
                       
 
                
            } elseif($this->startdate == null and $this->enddate == null and $this->searchByTable != null and $this->searchByGarson != null) {

               return Order::where('user_id','=',$this->searchByGarson)
                            ->where('table','=',$this->searchByTable)
                            ->where('company_id','=',auth()->user()->company_id);
                             

           } elseif($this->startdate == null and $this->enddate == null and $this->searchByTable != null and $this->searchByGarson == null) {

            
            return  Order::where('table','=',$this->searchByTable)
             ->where('company_id','=',auth()->user()->company_id);
 

           } elseif($this->startdate == null and $this->enddate == null and $this->searchByTable == null and $this->searchByGarson != null) {

                return Order::where('user_id','=',$this->searchByGarson)
                ->where('company_id','=',auth()->user()->company_id);

            
           }elseif($this->startdate != null and $this->enddate != null and $this->searchByTable == null and $this->searchByGarson != null){

            $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($this->enddate )->format('Y-m-d') .' 23:59:59';
            return  Order::where('user_id','=',$this->searchByGarson)
                    ->whereBetween('created_at',[$start,$end])
                    ->where('company_id','=',auth()->user()->company_id);

           }elseif($this->startdate != null and $this->enddate != null and $this->searchByTable != null and $this->searchByGarson == null){
                $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($this->enddate )->format('Y-m-d') .' 23:59:59';

           return Order::where('table','=',$this->searchByTable)
                    ->whereBetween('created_at',[$start,$end])
                    ->where('company_id','=',auth()->user()->company_id);



        

           }elseif($this->startdate != null and $this->enddate != null and $this->searchByTable == null and $this->searchByGarson == null){
              //Formatar as datas que estão a vir do fronte
              $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
              $end   = Carbon::parse($this->enddate )->format('Y-m-d') .' 23:59:59';

                return Order::whereBetween('created_at',[$start,$end])
                ->where('company_id','=',auth()->user()->company_id);

           }

    } catch (\Throwable $th) {
      return  redirect()->back();
    }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Categoria'];
    }

    

}