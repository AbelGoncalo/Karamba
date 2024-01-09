<?php

namespace App\Livewire\Admin;

use App\Models\HistoryOfAllActivities as ModelsHistoryOfAllActivities;
use Carbon\Carbon;
use Livewire\Component;

class HistoryOfAllActivities extends Component
{
    public $report_type = null, $type_service = null, $startdate = null, $enddate = null;
    public function render()
    {
        return view('livewire.admin.history-of-all-activities',[
            "historyOfActivities" => $this->filteringTypeOfReport()
        ])->layout('layouts.admin.app');
    }

    public function filteringTypeOfReport(){
       $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
       $end   = Carbon::parse($this->enddate)->format('Y-m-d') .' 23:59:59';
       
       return  ModelsHistoryOfAllActivities::whereBetween('created_at',[$start,$end])
       ->where('company_id',auth()->user()->company_id)
       ->get();       
    }

    public function barChartForLogs(){
        $history = HistoryOfAllActivities::where('company_id',auth()->user()->company_id)
        ->get();

        foreach($history as $allLogHistory =>$values){

        }
    }

            
        

}
