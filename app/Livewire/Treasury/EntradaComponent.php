<?php

namespace App\Livewire\Treasury;

use Livewire\Component;
use App\Models\{Delivery,DeliveryDetail,Company,Order};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use OpenSpout\Common\Entity\Style\Style;

class EntradaComponent extends Component
{
    use LivewireAlert,WithFileUploads;

    public $startdate = null,$enddate = null,$statusvalue = [], $items = [], $totalDelivery= 0,$totalOrder = 0, $totalSoma= 0 ;

    public $code,$user,$edit,$expirateDate,$search,$codeSearch,$confirm,$type,$value,$select,$times;
    protected $listeners = ["deleted"=>"deleted","close"=>"close"];
    protected $rules = ['type'=>'required','value'=>'required','user'=>'required','expirateDate'=>'required','times'=>'required',];
    protected $messages = ['type.required'=>'Campo Obrigatório','value.required'=>'Campo Obrigatório','expirateDate.required'=>'Campo Obrigatório','user.required'=>'Campo Obrigatório','times.required'=>'Campo Obrigatório'];

    public function render()
    {
        return view('livewire.treasury.entrada-component',[
            'deliveries'=>$this->deliveryList($this->startdate,$this->enddate, $this->totalSoma),
            'orders'=>$this->orderList($this->startdate,$this->enddate),
            'totalDelivery'=>Delivery::where('company_id','=',auth()->user()->company_id)->where('status', '=', 'entregue')->sum('total'),
            'totalOrder'=>Order::where('company_id','=',auth()->user()->company_id)->where('status', '=', 'pago')->sum('total'),


        ])->layout('layouts.treasury.app');
    }


    // Encomendas
    public function deliveryList($startdate,$enddate)
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

            }else{
                
                $this->totalDelivery = 0;
                $this->totalOrder = 0;

                $deliveries = Delivery::get();
                    foreach($deliveries as $delivery ){
                        $this->totalDelivery += $delivery->total;
                    }

                $orders = Order::get();
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


    public function changeStatus($id)
    {
        try {
           $delivery =  Delivery::find($id);
           $delivery->status = $this->statusvalue[$id];
           $delivery->save();

           if($delivery)
           {
            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Estado Alterado.'
            ]);

            $this->dispatch('searchOrder');
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


    public function viewOrders($id)
    {
        try {
           $this->items = Order::where('delivery_id','=',$id)->get();
            
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


    //Order
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

    //and Order

    public function exportExcel()
       {
           try {
   
   
               $data = $this->list($this->search,$this->codeSearch);
               $customData = [];
               $company = Company::find(auth()->user()->company_id);
   
               foreach ($data as $value) {
                   array_push($customData,[
                       'Restaurante'=>$company->companyname,
                       'Usuário'=>$value->user->name.' '.$value->user->lastname,
                       'Tipo'=>($value->type == 'fixed') ? 'Fixo':'Percentagem',
                       'Valor'=>($value->type == 'fixed') ? $value->value: $value->value.' %',
                       'Código'=>$value->code,
                       'Número de Uso'=>$value->times
                   ]);
               }
   
               $header_style = (new Style())->setFontBold();
               
               $rows_style = (new Style())
               ->setFontSize(10)
               ->setShouldWrapText()
               ->setBackgroundColor("EDEDED");
   
               return (new FastExcel($customData))
               ->headerStyle($header_style)
               ->rowsStyle($rows_style)
               ->download('cupons.xlsx');
   
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
       public function exportCsv()
       {
           try {
            $data = $this->list($this->search,$this->codeSearch);
            $customData = [];
            $company = Company::find(auth()->user()->company_id);

            foreach ($data as $value) {
                array_push($customData,[
                    'Restaurante'=>$company->companyname,
                    'Usuário'=>$value->user->name.' '.$value->user->lastname,
                    'Tipo'=>($value->type == 'fixed') ? 'Fixo':'Percentagem',
                    'Valor'=>($value->type == 'fixed') ? $value->value: $value->value.' %',
                    'Código'=>$value->code,
                    'Número de Uso'=>$value->times
                ]);
            }

            $header_style = (new Style())->setFontBold();
            
            $rows_style = (new Style())
            ->setFontSize(10)
            ->setShouldWrapText()
            ->setBackgroundColor("EDEDED");

            return (new FastExcel($customData))
            ->headerStyle($header_style)
            ->rowsStyle($rows_style)
            ->download('cupons.csv');
            
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

}


