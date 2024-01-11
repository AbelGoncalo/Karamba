<?php

namespace App\Exports;

use App\Models\HistoryOfAllActivities;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryOfAllActivitiesExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $start,$end;
    public function __construct($start = null,$end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function query(){

        try{

        if ($this->start != null || $this->end != null) {
            
        }

        }catch(\Exception $ex){

        }
    }

    public function headings(): array
    {
        return ['Tipo_acao','Descrição','Responsável', 'Data'];
    }
}
