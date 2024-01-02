<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Location;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;


 class  LocalExport  implements FromQuery, WithHeadings
{
    use Exportable;
    protected $search;
    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public  function query()
    {

        try {
          
       
        if ($this->search != null) {
        return Location::query()
            ->join('companies','locations.company_id','companies.id')
            ->select('companies.companyname','locations.location','locations.price')
            ->where('company_id','=',auth()->user()->company_id)
            ->where('location','=',$this->search);

           
        } else {
          
            return Location::query()
            ->join('companies','locations.company_id','companies.id')
            ->select('companies.companyname','locations.location','locations.price')
            ->where('company_id','=',auth()->user()->company_id);
        }

    } catch (\Throwable $th) {
      return  redirect()->back();
    }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Local','Preço'];
    }

    

}