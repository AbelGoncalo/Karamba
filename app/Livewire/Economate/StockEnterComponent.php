<?php

namespace App\Livewire\Economate;

use App\Exports\StockEnterExport;
use App\Exports\StockOutExport;
use App\Models\Company;
use App\Models\ProductEconomate;
use App\Models\StockCounter;
use App\Models\StockEnter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;


class StockEnterComponent extends Component
{
    use LivewireAlert;
    protected $listeners = ['close'=>'close','delete'=>'delete'];
    public $startdate = null,$enddate = null, $edit,$quantity,$description,$price,
    $unit,$source_product,$source,$product_economate_id,$expiratedate,$product_id,$quantityStock;
    protected $rules = [
        'quantity'=>'required',
        'price'=>'required',
        'unit'=>'required',
        'source_product'=>'required',
        'source'=>'required',
        'product_economate_id'=>'required',
        'expiratedate'=>'required',
    ];
    protected $messages = [
        'quantity.required'=>'Obrigatório',
        'price.required'=>'Obrigatório',
        'unit.required'=>'Obrigatório',
        'source_product.required'=>'Obrigatório',
        'source.required'=>'Obrigatório',
        'product_economate_id.required'=>'Obrigatório',
        'expiratedate.required'=>'Obrigatório',
    ];

    public function render()
    {
        return view('livewire.economate.stock-enter-component',[
            'stockenters'=>$this->searchStockEnter($this->startdate,$this->enddate),
            'items'=>ProductEconomate::where('company_id','=',auth()->user()->company_id)->get()
        ])->layout('layouts.economate.app');
    }

    public function getFixePrice($id)
    {
        try {
           $product  = ProductEconomate::find($id);

           $this->price = $product->fixe_price;

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
    public function searchStockEnter($startdate,$enddate)
    {
        try {
            if ($startdate != null and $enddate != null) {
                
                $start = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                $end   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';

                return StockEnter::where('company_id','=',auth()->user()->company_id)
                        ->whereBetween('created_at',[$start,$end])
                        ->get();
            }else{

                return StockEnter::where('company_id','=',auth()->user()->company_id)->get();
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
    public function save()
    {
    DB::beginTransaction();
        $this->validate($this->rules,$this->messages);
        try {
            
          $stockenter =   StockEnter::create([
                'quantity'=>$this->quantity,
                'description'=>$this->description,
                'price'=>$this->price,
                'unit_price'=>($this->price / $this->quantity),
                'unit'=>$this->unit,
                'source_product'=>$this->source_product,
                'source'=>$this->source,
                'product_economate_id'=>$this->product_economate_id,
                'company_id'=>auth()->user()->company_id,
                'user_id'=>auth()->user()->id,
                'expiratedate'=>$this->expiratedate,
            ]);



            $stockcounter = StockCounter::where('product_economate_id','=',$this->product_economate_id)->first();
    

            if($stockcounter)
            {
                $stockcounter->totalquantity += $this->quantity;
                $stockcounter->save();

                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => false,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação realizada com sucesso'
                ]);
            }else{

                StockCounter::create([
                    'product_economate_id'=>$this->product_economate_id,
                    'company_id'=>auth()->user()->company_id,
                    'totalquantity'=>$this->quantity,
                ]);


                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => false,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação realizada com sucesso'
                ]);
            }

            $this->clearFiled();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


    public function editStoque($id)
    {
        try {


                $stockenter = StockEnter::find($id);
                $this->edit = $stockenter->id;
                $this->quantity = $stockenter->quantity;
                $this->description = $stockenter->description;
                $this->price = $stockenter->price;
                $this->unit = $stockenter->unit;
                $this->source_product = $stockenter->source_product;
                $this->source = $stockenter->source;
                $this->product_economate_id = $stockenter->product_economate_id;
                $this->expiratedate = $stockenter->expiratedate;
            
            
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

    public function update()
    {
    
        $this->validate($this->rules,$this->messages);
        try {
            
            StockEnter::find($this->edit)->update([
                'quantity'=>$this->quantity,
                'description'=>$this->description,
                'price'=>$this->price,
                'unit_price'=>($this->price / $this->quantity),
                'unit'=>$this->unit,
                'source_product'=>$this->source_product,
                'source'=>$this->source,
                'product_economate_id'=>$this->product_economate_id,
                'company_id'=>auth()->user()->company_id,
                'user_id'=>auth()->user()->id,
                'expiratedate'=>$this->expiratedate,
            ]);


            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);

            $this->clearFiled();
            $this->dispatch('close');

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


    public function clearFiled()
    {
        $this->edit = '';
        $this->quantity = '';
        $this->description = '';
        $this->price = '';
        $this->unit = '';
        $this->source_product = '';
        $this->source = '';
        $this->product_economate_id = '';
        $this->expiratedate = '';
    }

    


    public function verifyQuantity()
    {
        try {
            if($this->product_id == null)
            {
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Selecione o Produto, que pretende vêr o estoque'
                ]);

            }else{

                $this->quantityStock = 0;
                $result = StockCounter::where('product_economate_id','=',$this->product_id)->first();
                if($result)
                {
                    $this->quantityStock = $result->totalquantity;
                    
                }else{
                    
                    $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Produto não encontrado'
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
    public function clear()
    {
        try {
            $this->product_id  = '';
            $this->quantityStock = 0;
        
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


    public function reportPdf()
    {
        try {
       
          
          $data = $this->searchStockEnter($this->startdate,$this->enddate);
          if($data->count() > 0){

            $company = Company::find(auth()->user()->company_id);
            $pdfContent = new Dompdf();
            $pdfContent = Pdf::loadView('livewire.report.stockenter',[
                'data'=>$data,
                'company'=>$company,
               
            ])->setPaper('a4', 'portrait')->output();
            return response()->streamDownload(
                fn () => print($pdfContent),
                "Relatório-de-stock.pdf"
            );
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
         
            
                return (new StockEnterExport($this->startdate,$this->enddate))->download('entrada_de_estoque.xls'); 


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
