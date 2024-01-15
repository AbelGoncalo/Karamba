<?php

namespace App\Livewire\Treasury;

use App\Exports\DeliveryReportExport;
use App\Exports\OrderReportExport;
use Livewire\Component;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Models\{Uuse,Company,Order,Delivery, HistoryOfAllActivities, Saque};

class TreasuryReportComponent extends Component
{

    use LivewireAlert;
    public $startdate = null,$enddate = null,$statusvalue = [], $items = [], $totalDelivery= 0,$totalOrder = 0, $totalSoma= 0, $total=0, $totalSaque=0;

    public function render()
    {
        return view('livewire.treasury.treasury-report-component', [
            'data'=>$this->getData($this->startdate,$this->enddate),
            'saques'=>$this->saqueList($this->startdate,$this->enddate,$this->totalSaque),
            'orders'=>$this->orderList($this->startdate,$this->enddate),

        ])->layout('layouts.treasury.app');
    }

    // Encomendas
    public function getData($startdate,$enddate)
    {
        try {
          
            if($startdate != null and  $enddate != null)
            {
                $initialdate = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $enddate   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';

                $this->totalDelivery = 0;
                $this->totalOrder = 0;

                $deliveries = Delivery::whereBetween('created_at',[$initialdate,$enddate])
                    ->where('company_id','=',auth()->user()->company_id)
                    ->get();
                    foreach($deliveries as $delivery ){
                        $this->totalDelivery += $delivery->total;
                    }

                  
                $orders = Order::whereBetween('created_at',[$initialdate,$enddate])
                    ->where('company_id','=',auth()->user()->company_id)
                    ->get();

                    foreach($orders as $order ){
                        $this->totalOrder += $order->total;
                    }
               
                    $this->totalSoma = $this->totalDelivery + $this->totalDelivery;

                return $deliveries;

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

    
    public function resetQuery()
    {
        try {
            $this->startdate = null;
            $this->enddate = null;
            
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



    public function export($type)
    {
        try {

            if ($type == 'orders') {
                # code...
                return (new OrderReportExport($this->startdate,$this->enddate))->download('Pedidos.xls',\Maatwebsite\Excel\Excel::XLS); 
            } else {
                # code...
                return (new DeliveryReportExport($this->startdate,$this->enddate))->download('encomendas.xls',\Maatwebsite\Excel\Excel::XLS); 
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


    public function saqueList($startdate,$enddate)
    {

        try {
          
            if($startdate != null and  $enddate != null)
            {
                $initialdate = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $enddate   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';

                $saques = Saque::whereBetween('created_at',[$initialdate,$enddate])
                ->where('company_id','=',auth()->user()->company_id)
                ->get();

                foreach($saques as $saque){
                    $this->totalSaque += $saque->value;
                }

                return $saques;

            }else{
                
                $saques = Saque::where('company_id','=',auth()->user()->company_id)->get();
                foreach($saques as $saque){
                    $this->totalSaque += $saque->value;
                }

                return $saques;
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


    public function orderList($startdate,$enddate)
    {
        try {

            
            $this->totalOrder = 0;
          
            if($startdate != null and  $enddate != null)
            {
                $initialdate = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $enddate   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';

                $orders = Order::whereBetween('created_at',[$initialdate,$enddate])
                ->where('company_id','=',auth()->user()->company_id)
                ->get();

                foreach($orders as $order ){
                    $this->totalOrder += $order->total;
                }

                return $orders;

            }else{
                $this->totalOrder = 0;
                $orders = Order::get();

                foreach($orders as $order ){
                    $this->totalOrder += $order->total;
                }

                return $orders;
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



    //Método para imprimir o relatorio de encomendas
    public function PrintDelivery(){
        try {
            $total = 0;
           $data = $this->getData($this->startdate,$this->enddate);
           
            if($data->count() > 0){
                $company = Company::find(auth()->user()->company_id);
                $pdfContent = new Dompdf();

            //Log de actividades para exportação do relatório de saída em Excel
            $log = new HistoryOfAllActivities();
            $log->tipo_acao = 'Exportar relatório de saídas em PDF';
            $log->company_id = auth()->user()->company_id;
            $log->descricao = 'O Tesoureiro '. auth()->user()->name.' '.auth()->user()->lastname.' exportou o relatório de saídas em  PDF';
            $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
            $log->save();

                foreach($data as $item)
                {
                    $total = $total + $item->total;
                }

              

                $pdfContent = PDF::loadView('livewire.report.deliveryreport',[
                    'data'=>$data,
                    'company'=>$company,
                    'total'=>$total,
                   
                ])->setPaper('a4', 'portrait')->output();
                    $this->resetQuery();
                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "Relatório-de-encomenda.pdf"
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


    //Método para imprimir relatório de pedidos
    public function PrintOrder(){
        try {
            $total = 0;
           $data = $this->orderList($this->startdate,$this->enddate);
            if($data->count() > 0){
                $company = Company::find(auth()->user()->company_id);
                $pdfContent = new Dompdf();

                foreach($data as $item)
                {
                    $total = $total + $item->total;
                }

              

                $pdfContent = PDF::loadView('livewire.report.orderReport',[
                    'data'=>$data,
                    'company'=>$company,
                    'total'=>$total,
                   
                ])->setPaper('a4', 'portrait')->output();
                    $this->resetQuery();
                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "Relatório-de-pedidos.pdf"
                );
            }
        }catch(\Exception $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


    //Método para imprimir relatório de saques
    public function PrintSaque(){
        try {
            $total = 0;
           $data = $this->saqueList($this->startdate,$this->enddate);
            if($data->count() > 0){
                $company = Company::find(auth()->user()->company_id);
                $pdfContent = new Dompdf();

                foreach($data as $item)
                {
                    $total = $total + $item->total;
                }

              

                $pdfContent = PDF::loadView('livewire.report.saquereport',[
                    'data'=>$data,
                    'company'=>$company,
                    'total'=>$total,
                   
                ])->setPaper('a4', 'portrait')->output();
                    $this->resetQuery();
                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "Relatório-de-saidas.pdf"
                );
            }
        }catch(\Exception $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


}
