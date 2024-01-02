<?php

namespace App\Exports;


use App\Models\Table;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

 class TableExport  implements FromQuery, WithHeadings
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
         

                $data =   Table::query()->join('companies','tables.company_id','companies.id')
                ->select('companies.companyname','tables.number','tables.location')
                ->where('tables.description','like','%'.$this->search.'%')
                ->where('items.company_id','=',auth()->user()->company_id);
                
                if ($data->count() > 0) {
                    return $data;
                    
                }
            } else {
              
                $data =    Table::query()->join('companies','tables.company_id','companies.id')
                ->select('companies.companyname','tables.number','tables.location')
                ->where('tables.company_id','=',auth()->user()->company_id);
                if ($data->count() > 0) {
                    return $data;
                    
                }
                
            }
        } catch (\Throwable $th) {
            return redirect()->back();
        }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Mesa nº','Localização'];
    }

    

}