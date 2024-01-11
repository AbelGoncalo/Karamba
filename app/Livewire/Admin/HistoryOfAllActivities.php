<?php

namespace App\Livewire\Admin;

use App\Exports\HistoryOfAllActivitiesExport;
use App\Models\HistoryOfAllActivities as ModelsHistoryOfAllActivities;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class HistoryOfAllActivities extends Component
{
    public $authorOfActivity = null, $report_type = null, $type_service = null, $startdate = null, $enddate = null;
    public function render()
    {
        
        $responsable = User::where('company_id', auth()->user()->company_id)
        ->where('users.profile' ,'<>','client-local')
        ->get();
        return view('livewire.admin.history-of-all-activities',[
            "historyOfActivities" => $this->filteringTypeOfReport(),
            "responsable" => $responsable
        ])->layout('layouts.admin.app');
    }

    public function filteringTypeOfReport(){
       $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
       $end   = Carbon::parse($this->enddate)->format('Y-m-d') .' 23:59:59';
       $author = $this->authorOfActivity;

        if ($author == 'Todos'){
            return  ModelsHistoryOfAllActivities::whereBetween('created_at',[$start,$end])
            ->where('company_id',auth()->user()->company_id)            
            ->get();       
        }else{
            return  ModelsHistoryOfAllActivities::whereBetween('created_at',[$start,$end])
            ->where('company_id',auth()->user()->company_id)
            ->where('responsavel',$author)
            ->get();       
        }



    }

    public function barChartForLogs(){
        $history = HistoryOfAllActivities::where('company_id',auth()->user()->company_id)
        ->get();

        foreach($history as $allLogHistory =>$values){

        }
    }

       
    public function printHistoryOfAllActivities(){
        $data = $this->filteringTypeOfReport();
        $companyName = User::join('companies', 'users.company_id' , '=', 'companies.id')
        ->where('users.company_id',auth()->user()->company_id)
        ->limit(1)
        ->get();

        // instantiate and use the dompdf class        
        $dompdf = new Dompdf();        
        $dompdf = Pdf::loadView('livewire.report.report-history-of-all-activities',[
            'companyName' => $companyName,
            'data' => $data ,
        ])->setPaper('a4', 'portrait')->output();
        return response()->streamDownload(
            fn () => print($dompdf),
            "Relatório-de-log-atividades.pdf"
        );
    }

    public function exportExcel(){
        
        dd("exportar excel");
       // return (new HistoryOfAllActivitiesExport($start,$end))->download('relatorio-actividades.xls',\Maatwebsite\Excel\Excel::XLS); 

    }
        

}
