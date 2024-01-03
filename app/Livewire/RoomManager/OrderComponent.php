<?php

namespace App\Livewire\RoomManager;

use App\Exports\OrderExport;
use App\Models\Company;
use App\Models\DetailOrder;
use App\Models\Order;
use Livewire\Component;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

class OrderComponent extends Component
{
    use LivewireAlert;
    public $startdate = null,$enddate = null,$details = [];

    public function mount()
    {
        $this->startdate =  Carbon::parse($this->startdate)->format('Y-m-d');
        $this->enddate   = Carbon::parse($this->enddate )->format('Y-m-d');
 
    }
    
    public function render()
    {
        return view('livewire.room-manager.order-component',[
            'data'=>$this->getData($this->startdate,$this->enddate),
        ])->layout('layouts.room_manager.app');
    }

 

    public function getData($startdate = null,$enddate = null,$table = null,$garson = null)
    {
        try {

            if ($startdate != null and $enddate != null )  {

                $start = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';
                $data = Order::whereBetween('created_at',[$start,$end])
                ->where('company_id','=',auth()->user()->company_id)
                ->get();


                 return $data;
                
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
          

            $this->details = DetailOrder::where('order_id','=',$id)
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


    public function export()
    {
        try {
                $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($this->enddate )->format('Y-m-d') .' 23:59:59';

            
                return (new OrderExport($start,$end))->download('pedidos.xls',\Maatwebsite\Excel\Excel::XLS); 

            

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
           
                if ($this->startdate != null || $this->enddate != null) {

                    $start = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
                    $end   = Carbon::parse($this->enddate)->format('Y-m-d') .' 23:59:59';
            
                    $data = Order::join('detail_orders','orders.id','detail_orders.order_id')
                    ->join('companies','companies.id','orders.company_id')
                    ->select('detail_orders.item','detail_orders.price','detail_orders.quantity','detail_orders.tax','detail_orders.discount','detail_orders.subtotal')
                    ->where('orders.company_id','=',auth()->user()->company_id)
                     ->whereBetween('orders.created_at',[$start,$end])->get();
                     
         
                 } else {
                   
                    $data = Order::join('detail_orders','orders.id','detail_orders.order_id')
                     ->join('companies','companies.id','orders.company_id')
                     ->select('detail_orders.item','detail_orders.price','detail_orders.quantity','detail_orders.tax','detail_orders.discount','detail_orders.subtotal')
                     ->where('orders.company_id','=',auth()->user()->company_id)->get();
          
                 }
                
                if($data->count() > 0){
                    foreach ($data as  $value) {
                       $total += $value->price;
                }
      
                  $company = Company::find(auth()->user()->company_id);
                  $pdfContent = new Dompdf();
                  $pdfContent = Pdf::loadView('livewire.report.order',[
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
