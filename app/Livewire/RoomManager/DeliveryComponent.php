<?php

namespace App\Livewire\RoomManager;

use App\Exports\DeliveryExport;
use Livewire\Component;
use App\Models\{Company, Delivery,DeliveryDetail, HistoryOfAllActivities};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

class DeliveryComponent extends Component
{
    use LivewireAlert;
    public $startdate = null,$enddate = null,$statusvalue = [],$items = [];
    protected $listeners = ['close'=>'close','delete'=>'delete'];

    public function mount()
    {
        $this->startdate =  Carbon::parse($this->startdate)->format('Y-m-d');
        $this->enddate   = Carbon::parse($this->enddate )->format('Y-m-d');
 
    }
    public function render()
    {
       
        return view('livewire.room-manager.delivery-component',[
            'deliveries'=>$this->deliveryList($this->startdate,$this->enddate),
        ])->layout('layouts.room_manager.app');
    }




    public function deliveryList($startdate,$enddate)
    {
        try {
          
            if($startdate != null and  $enddate != null)
            {
                $initialdate = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $enddate   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';

                return Delivery::whereBetween('created_at',[$initialdate,$enddate])
                ->where('company_id','=',auth()->user()->company_id)
                ->get();

            }else{
             
                return Delivery::where('company_id','=',auth()->user()->company_id)
                ->where('status','<>','ENTREGUE')
                ->whereBetween('created_at',[date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59'])    
                ->get();
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

    
    public function changeStatus($id)
    {
        try {
            $delivery =  Delivery::find($id);
            
         
           if ($delivery->status == 'PENDENTE') {
               
              
            if ($this->statusvalue[$id] == 'ACEITE') {
                $delivery->status = $this->statusvalue[$id];
                $delivery->save();

                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Estado Alterado.'
                ]);
            }else{
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Não pode alterar para este estado de momento.'
                ]);
            }
           } elseif($delivery->status == 'PRONTO') {

            if ($this->statusvalue[$id] == 'A CAMINHO') {

                $delivery->status = $this->statusvalue[$id];
                $delivery->save();

                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Estado Alterado.'
                ]);

            }else{
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Não pode alterar para este estado de momento.'
                ]);
            }

           }elseif($delivery->status == 'A CAMINHO') {

            if ($this->statusvalue[$id] == 'ENTREGUE') {

                $delivery->status = $this->statusvalue[$id];
                $delivery->save();

                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Estado Alterado.'
                ]);

                if($delivery->status == 'ENTREGUE'){
                    $delivery->finddetail = null;
                    $delivery->save();
       
                    $this->alert('success', 'SUCESSO', [
                       'toast'=>false,
                       'position'=>'center',
                       'showConfirmButton' => true,
                       'confirmButtonText' => 'OK',
                       'text'=>'Estado Alterado.'
                    ]);
                   }

            }else{
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Não pode alterar para este estado de momento.'
                ]);
            }

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

    public function viewItems($id)
    {
        try {
           $this->items = DeliveryDetail::where('delivery_id','=',$id)->get();
            
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


    public function download($id)
    {
        try {

            
            $delivery = Delivery::find($id);           

            $test =   $this->alert('info', '', [
                'toast'=>false,
                'position'=>'center',
                'timer'=>1000,
                'timerProgressBar'=> true,
                'text'=>'A PROCESSAR DOWNLOAD...'
            ]);

         
            return response()->download(storage_path().'/app/public/receipts/'.$delivery->receipt);
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


    public function export()
    {
        try {

            
                $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($this->enddate )->format('Y-m-d') .' 23:59:59';

                
                //Registar o log de atividades de exportaçao do ficheiro do Excel
                $log = new HistoryOfAllActivities();
                $log->tipo_acao = 'Exportar relatório de encomendas';
                $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
                $log->company_id = auth()->user()->company_id;
                $log->descricao = 'O chefe de sala '.auth()->user()->name.''.auth()->user()->lastname.' exportou o relatório de encomendas em formato excel';
                $log->save();

         
                return (new DeliveryExport($start,$end))->download('encomendas.xls',\Maatwebsite\Excel\Excel::XLS); 

            

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

    public function exportPdf()
    {
        try {

                $total = 0;
                $data = $this->deliveryList($this->startdate,$this->enddate);

                if($data->count() > 0){
                    foreach ($data as  $value) {
                       $total +=$value->total;


                       //Registar o log de atividades de exportaçao do ficheiro do Excel
                        $log = new HistoryOfAllActivities();
                        $log->tipo_acao = 'Exportar relatório de encomendas';
                        $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
                        $log->company_id = auth()->user()->company_id;
                        $log->descricao = 'O chefe de sala '.auth()->user()->name.''.auth()->user()->lastname.' exportou o relatório de encomendas em formato pdf';
                        $log->save();
                    
                }

      
                  $company = Company::find(auth()->user()->company_id);
                  $pdfContent = new Dompdf();
                  $pdfContent = Pdf::loadView('livewire.report.delivery',[
                      'data'=>$data,
                      'company'=>$company,
                      'total'=>$total
                     
                  ])->setPaper('a4', 'portrait')->output();
                  return response()->streamDownload(
                      fn () => print($pdfContent),
                      "Relatório-de-Pedidos.pdf"
                  );

                  

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
