<?php

namespace App\Livewire\Admin;

use App\Exports\HistoryOfAllActivitiesExport;
use App\Models\Company;
use App\Models\HistoryOfAllActivities as ModelsHistoryOfAllActivities;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class HistoryOfAllActivities extends Component
{
    public $companyname = null, $authorOfActivity = null, $report_type = null, $type_service = null, $startdate = null, $enddate = null;
    public function render()
    {

        

    
        //Lógica para o gráfico de Barras
        $logChartBar = ModelsHistoryOfAllActivities::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at',date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $labels = [];
        $data = [];
        $colors = ['rgba(255, 99, 132, 0.2)' , 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(201, 203, 207, 0.2)'];
        $borders = ['rgb(255, 99, 132)','rgb(255, 159, 64)' ,'rgb(255, 205, 86)', 'rgb(75, 192, 192)',  'rgb(54, 162, 235)', 'rgb(153, 102, 255)', 'rgb(201, 203, 207)'];

        
        
        for ($i=1; $i<=12; $i++){
            $month = date('F',mktime(0,0,0,$i,1));
            $count = 0;
            
                    foreach($logChartBar as $chart){
                        if ($chart->month == $i){
                            $count = $chart->count;
                            break;
                        }
                    }
            
                    array_push($labels,$month);
                    array_push($data,$count);

        }

        $datasets = [
            [
                'label' => 'Actividades por mês',
                'data' => $data,
                'backgroundColor' => $colors,
                'borderColor' => $borders
            ]
            ];


            //Lógica para o gráfico de Pizza
            $actionTypes = ModelsHistoryOfAllActivities::select(['created_at'])->get();
            foreach ($actionTypes as $action){
                $dataPizza[] = strtoupper("'".'DATA: MÊS DE: '.\Carbon\Carbon::parse($action->created_at)->translatedFormat('F')."'");
                $quantity[] = ModelsHistoryOfAllActivities::all()->count();
            }

            //Formatar para o Chartjs
            $actionLabel = implode(',',$dataPizza);
            $actionTotal = implode(',', $quantity);

            $datasets = [
                [
                    'label' => 'Actividades por mês',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => $borders
                ]
                ];
            
        
        $companyData = Company::get();
        $responsable = User::where('company_id', auth()->user()->company_id)
        ->where('users.profile' ,'<>','client-local')
        ->get();
        return view('livewire.admin.history-of-all-activities',[
            "historyOfActivities" => $this->filteringTypeOfReport(),
            "responsable" => $responsable,
            "companyData" => $companyData,
            'datasets' => $datasets,
            'labels' =>$labels,
            'actionLabel' =>$actionLabel,
            'actionTotal' =>$actionTotal
        ])->layout('layouts.admin.app');

       
    }
    

    public function filteringTypeOfReport(){
       $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
       $end   = Carbon::parse($this->enddate)->format('Y-m-d') .' 23:59:59';
       $author = $this->authorOfActivity;
       $companyName = $this->companyname;


        if (!empty($companyName) ){
            return  ModelsHistoryOfAllActivities::whereBetween('created_at',[$start,$end])
            ->where('company_id', $companyName)    
            ->get();       
        }else if(!empty($companyName)){

            return  ModelsHistoryOfAllActivities::whereBetween('created_at',[$start,$end])
            ->where('responsavel', $author)    
            ->get();       

        }else{
            return  ModelsHistoryOfAllActivities::whereBetween('created_at',[$start,$end])
            ->where('company_id', $companyName)    
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
        ])->setPaper('a4', 'landscape')->output();
        return response()->streamDownload(
            fn () => print($dompdf),
            "Relatório-de-log-atividades.pdf"
        );
    }

    public function exportExcel(){
        return Excel::download(new HistoryOfAllActivitiesExport, 'relatório-log-actividades.xls');
    }
        

}
