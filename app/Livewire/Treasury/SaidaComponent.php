<?php

namespace App\Livewire\Treasury;

use App\Exports\DebitReportExport;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use App\Models\{Delivery,DeliveryDetail,Company,Saque, Order};
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Rap2hpoutre\FastExcel\FastExcel;
use OpenSpout\Common\Entity\Style\Style;

class SaidaComponent extends Component
{

   
    use LivewireAlert,WithFileUploads;


    public $startdate = null,$enddate = null,$statusvalue = [], $saldoAtual= 0, $saqueTotal=0 ;

    public $code,$user,$edit,$expirateDate,$search,$codeSearch,$confirm,$type,$value,$select,$times,$description,$date;

    protected $listeners = ["deleted"=>"deleted","close"=>"close"];
    protected $rules = [
        'description'=>'required',
        'value'=>'required',
    ];
    
    protected $messages = ['type.required'=>'Campo Obrigatório','value.required'=>'Campo Obrigatório','expirateDate.required'=>'Campo Obrigatório','user.required'=>'Campo Obrigatório','times.required'=>'Campo Obrigatório'];

    public function render()
    {
       
        return view('livewire.treasury.saida-component',[
            'saques'=>$this->saqueList($this->startdate,$this->enddate),
            'saldoAtual'=>$this->saldoAtual,
            'saqueTotal'=>$this->saqueTotal,
            'totalDelivery'=>Delivery::where('company_id','=',auth()->user()->company_id)->where('status', '=', 'entregue')->sum('total') ?? '0',
            'totalOrder'=>Order::where('company_id','=',auth()->user()->company_id)->where('status', '=', 'pago')->sum('total') ?? '0',
            'totalSaque'=>Saque::where('company_id','=',auth()->user()->company_id)->sum('value') ?? '0',

        ])->layout('layouts.treasury.app');
    }


     //salvar saques
     public function save(){

        $Totaldelivery=Delivery::where('company_id','=',auth()->user()->company_id)
            ->where('status', '=', 'entregue')->sum('total');    
        
        $TotalOrder=Order::where('company_id','=',auth()->user()->company_id)
            ->where('status', '=', 'pago')->sum('total');
               
        $saldo = $Totaldelivery + $TotalOrder;
       
        try{

            if($this->value >= $saldo){

                $this->alert('error', 'ERRO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Não pode fazer um saque maior que o saldo actual'
                ]);

                
            }else{

                Saque::create([
                    'description' =>$this->description,
                    'value' =>$this->value,
                    'user_id' =>auth()->user()->id,
                    'company_id' =>auth()->user()->company_id,
                ]);
    
                $this->dispatch('close');
                $this->alert('success', 'SUCESSO', [
                    'toast'=>true,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação Realizada Com Sucesso.'
                ]);
                
            }
            
        }catch(\Throwable $th){
           
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


    public function saqueList($startdate,$enddate)
    {

        try {
          
            if($startdate != null and  $enddate != null)
            {
                $initialdate = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
                $enddate   = Carbon::parse($this->enddate)->format('Y-m-d') .' 23:59:59';
               
              
                return Saque::whereBetween('created_at',[$initialdate,$enddate])
                ->where('company_id','=',auth()->user()->company_id)
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

       public function export()
       {
           try {
   

                   return (new DebitReportExport($this->startdate,$this->enddate))->download('saques.xls',\Maatwebsite\Excel\Excel::XLS); 

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


          //Método para imprimir o relatorio de encomendas
    public function exportPdf(){
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

              

                $pdfContent = PDF::loadView('livewire.report.debitReport',[
                    'data'=>$data,
                    'company'=>$company,
                    'total'=>$total,
                   
                ])->setPaper('a4', 'portrait')->output();
                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "Relatório-de-encomenda.pdf"
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
