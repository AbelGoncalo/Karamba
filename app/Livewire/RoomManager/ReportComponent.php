<?php

namespace App\Livewire\RoomManager;

use App\Exports\ReportRoomManagerExport;
use App\Models\Company;
use App\Models\HistoryOfAllActivities;
use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Rap2hpoutre\FastExcel\FastExcel;
use Livewire\WithPagination;


class ReportComponent extends Component
{
    use LivewireAlert,WithPagination;
    public $startdate = null,$enddate = null,$searchByTable = null,$searchByGarson = null,$total = 0;
    public function render()
    {
        return view('livewire.room-manager.report-component',[
            'data'=>$this->getData($this->startdate,$this->enddate,$this->searchByTable,$this->searchByGarson),
            'tables'=>$this->getTables(),
            'garsons'=>$this->getGarsons(),
        ])->layout('layouts.room_manager.app');
    }


    public function getData($startdate = null,$enddate = null,$table = null,$garson = null)
    {
        try {
            $this->total = 0;

            if ($startdate != null and $enddate != null and $table != null and $garson != null)  {

                $start = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';
                $data = Order::where('user_id','=',$garson)
                        ->where('table','=',$table)
                        ->whereBetween('created_at',[$start,$end])
                        ->where('company_id','=',auth()->user()->company_id)
                        ->get();


                        foreach($data as $item)
                        {
                            $this->total += $item->total;
                        }

                return $data;
                
            } elseif($startdate == null and $enddate == null and $table != null and $garson != null) {

                $data = Order::where('user_id','=',$garson)
                            ->where('table','=',$table)
                            ->where('company_id','=',auth()->user()->company_id)
                            ->get();

                            foreach($data as $item)
                        {
                            $this->total += $item->total;
                        }

                        return $data;

           } elseif($startdate == null and $enddate == null and $table != null and $garson == null) {

            
             $data = Order::where('table','=',$table)
             ->where('company_id','=',auth()->user()->company_id)
             ->get();

                         foreach($data as $item)
                        {
                            $this->total += $item->total;
                        }

                return $data;

           } elseif($startdate == null and $enddate == null and $table == null and $garson != null) {

                $data =  Order::where('user_id','=',$garson)
                ->where('company_id','=',auth()->user()->company_id)
                 ->get();

                            foreach($data as $item)
                        {
                            $this->total += $item->total;
                        }

                return $data;
           }elseif($startdate != null and $enddate != null and $table == null and $garson != null){

            $start = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';
            $data =  Order::where('user_id','=',$garson)
                    ->whereBetween('created_at',[$start,$end])
                    ->where('company_id','=',auth()->user()->company_id)
                    ->get();

                        foreach($data as $item)
                        {
                            $this->total += $item->total;
                        }

                return $data;
           }elseif($startdate != null and $enddate != null and $table != null and $garson == null){
                $start = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';

            $data =  Order::where('table','=',$table)
                    ->whereBetween('created_at',[$start,$end])
                    ->where('company_id','=',auth()->user()->company_id)
                    ->get();

                    foreach($data as $item)
                    {
                        $this->total += $item->total;
                    }

            return $data;

           }elseif($startdate != null and $enddate != null and $table == null and $garson == null){
              //Formatar as datas que estão a vir do fronte
              $start = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
              $end   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';

                $data =  Order::whereBetween('created_at',[$start,$end])
                ->where('company_id','=',auth()->user()->company_id)
                ->get();

                foreach($data as $item)
                {
                    $this->total += $item->total;
                }

                return $data;
           }else{

            $this->total = 0;
            return [];

           }
            

            
            
        } catch (\Throwable $th) {
          
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }

    public function getGarsons()
    {
        try {
            return User::where('profile','=','garçon')
            ->where('company_id','=',auth()->user()->company_id)
            ->get();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }
    public function getTables()
    {
        try {
            return Table::where('company_id','=',auth()->user()->company_id)
            ->get();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


    //Metodo para imprimir o relatorio
    public function Print(){
        try {



            $total = 0;
            $data = $this->getData($this->startdate,$this->enddate,$this->searchByTable,$this->searchByGarson);
            if($data->count() > 0){
                $company = Company::find(auth()->user()->company_id);
                $pdfContent = new Dompdf();

                foreach($data as $item)
                {
                    $total = $total + $item->total;
                }

                // $garsonName = User::where('id',$this->searchByGarson)
                // ->first();
                $garsonName = User::where('id',$this->searchByGarson)
                ->get();               

                foreach($garsonName as $garson){                    
                    //Registo de log de atividades para exportação dos documentos
                    $log = new HistoryOfAllActivities();
                    $log->tipo_acao = "Exportar relatório PDF";
                    $log->company_id = auth()->user()->company_id;
                    $log->descricao = 'O chefe de sala '. auth()->user()->name.''.auth()->user()->lastname.' exportou o relatório da mesa '
                    .$this->searchByTable.' do Garçon ' .$garson->name.''.$garson->lastname;
                    
                    $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
                    $log->save();
                    
                }
               



              

                $pdfContent = PDF::loadView('livewire.report.report',[
                    'data'=>$data,
                    'company'=>$company,
                    'total'=>$total,
                   
                ])->setPaper('a4', 'portrait')->output();
                    $this->resetQuery();
                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "Relatório-de-arrecadação.pdf"
                );

       

            }

               
        }catch(\Exception $th) {
            dd($th->getMessage());
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }

    public function resetQuery()
    {
        try {
            $this->startdate = null;
            $this->enddate = null;
            $this->searchByTable = null;
            $this->searchByGarson = null;
            $this->total = 0;

        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


    public function export($format)
    {
        try {
         
            if($format == 'pdf')
            {
                return (new ReportRoomManagerExport($this->startdate,$this->enddate,$this->searchByTable,$this->searchByGarson))->download('Pedidos.'.$format,\Maatwebsite\Excel\Excel::DOMPDF); 
                
            }elseif($format == 'xls')
            {
                return (new ReportRoomManagerExport($this->startdate,$this->enddate,$this->searchByTable,$this->searchByGarson))->download('Pedidos.'.$format,\Maatwebsite\Excel\Excel::XLS); 

            }

        } catch (\Throwable $th) {
            
            $this->alert('warning', 'AVISO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Sem dados para exportar'
            ]);
        }
    }
}
