<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Item;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

 class  ItemExport  implements FromQuery, WithHeadings
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
         

            $data =   Item::query()->join('companies','items.company_id','companies.id')
            ->select('companies.companyname','items.description','items.price','items.status')
            ->where('items.description','like','%'.$this->search.'%')
            ->where('items.company_id','=',auth()->user()->company_id);
            if ($data->count() > 0) {
                return $data;
                
            }
        } else {
          
            $data =    Item::query()->join('companies','items.company_id','companies.id')
            ->select('companies.companyname','items.description','items.price','items.quantity','items.status')
            ->where('items.company_id','=',auth()->user()->company_id);

            if ($data->count() > 0) {
                return $data;
                
            }
            
        }
      } catch (\Throwable $th) {
        return back();
      }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Descrição','Preço','Quantidade','Estado'];
    }

    

}