<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;


 class  CategoryExport  implements FromQuery, WithHeadings
{
    use Exportable;
    protected $search;
    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function query()
    {

        try {
          
       
        if ($this->search != null) {
        return Category::query()->join('companies','categories.company_id','companies.id')
            ->select('companies.companyname','categories.description')
            ->where('categories.description','like','%'.$this->search.'%');
 

        } else {
          
            return Category::query()->join('companies','categories.company_id','companies.id')
            ->select('companies.companyname','categories.description');
           
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