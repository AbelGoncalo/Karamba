<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\HistoryOfAllActivities;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class HistoryOfAllActivitiesExport implements FromCollection,WithHeadings
{
    public $startdate = null, $enddate = null;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
        $end   = Carbon::parse($this->enddate )->format('Y-m-d') .' 23:59:59';
       
        return HistoryOfAllActivities::select('tipo_acao','descricao','responsavel', 'created_at')
        ->whereBetween('created_at',[$start,$end])
        ->get();
    }

    public function title(): string
    {
        return 'relatório-log-actividades';
    }

    public function headings(): array
    {
        return [
            'Tipo de ação',
            'Descrição',
            'Responsável',
            'Data'
        ];
    }
}
