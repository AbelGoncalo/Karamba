<?php

namespace App\Livewire\Economate;

use App\Exports\StockOutExport;
use App\Models\Company;
use App\Models\Compartment;
use App\Models\CountStock;
use App\Models\ProductEconomate;
use App\Models\StockCounter;
use App\Models\StockEnter;
use App\Models\StockOut;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

class StockOutComponent extends Component
{

    use LivewireAlert;

    public $description,$edit,$startdate,$enddate,$usetype,$chef,$product_economate_id,$quantity,$unit,$from,$to;
    protected $listeners = ['close'=>'close'];

    protected $rules = [
        'quantity'=>'required',
        'usetype'=>'required',
        'chef'=>'required',
        'unit'=>'required',
        'product_economate_id'=>'required',
    ];
    protected $messages = [
        'quantity.required'=>'Obrigatório',
        'unit.required'=>'Obrigatório',
        'product_economate_id.required'=>'Obrigatório',
        'chef.required'=>'Obrigatório',
        'usetype.required'=>'Obrigatório',
    ];

    public function getUnit()
    {
    
          try {
            if ($this->product_economate_id) {
                
                $product =  ProductEconomate::find($this->product_economate_id);
              
                $this->unit =  $product->unit;
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
    
    public function render()
    {
        return view('livewire.economate.stock-out-component',[
            'stockouts'=>$this->searchStockOut($this->startdate,$this->enddate),
            'items'=>ProductEconomate::where('company_id','=',auth()->user()->company_id)->get(),
            'Compartments'=>Compartment::where("company_id","=",auth()->user()->company_id)->get()

        ])->layout('layouts.economate.app');
    }


        public function save()
        {
         DB::beginTransaction();
             try {
           
                $stockcounter = StockCounter::where('product_economate_id','=',$this->product_economate_id)
                ->first();
              

                if ($stockcounter) {
                   
                    if ($this->quantity > $stockcounter->totalquantity) {
                        $this->alert('warning', 'AVISO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Quantidade Superior a disponível em estoque'
                        ]);
                    }else{

                        if ($this->from == $this->to) {

                            $this->alert('warning', 'AVISO', [
                                'toast'=>false,
                                'position'=>'center',
                                'showConfirmButton' => true,
                                'confirmButtonText' => 'OK',
                                'text'=>'Não pode dar saida para o mesmo local'
                            ]);

                        }else{
                            $stockenter =  StockOut::create([
                                'quantity'=>$this->quantity,
                                'usetype'=>$this->usetype,
                                'chef'=>$this->chef,
                                'unit'=>$this->unit,
                                'description'=>$this->description,
                                'product_economate_id'=>$this->product_economate_id,
                                'company_id'=>auth()->user()->company_id,
                                'user_id'=>auth()->user()->id,
                                'from'=>$this->from,
                                'to'=>$this->to
                            ]);


                            if ($stockenter) {
                        
                                $stockcounter->totalquantity -= $this->quantity;
                                $stockcounter->save();
     
     
                                $this->alert('success', 'SUCESSO', [
                                 'toast'=>false,
                                 'position'=>'center',
                                 'showConfirmButton' => true,
                                 'confirmButtonText' => 'OK',
                                 'text'=>'Operação Realizada Com Sucesso.'
                             ]);
                                 
     
                             }
                        }

                    }
                } else {
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Produto Sem estoque'
                    ]);
                }
                
                         
                 
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


        public function editstockout($id)
        {
            try {

                $stockout = StockOut::find($id);
               
             
                $this->description =  $stockout->description;
                $this->edit =  $stockout->id;
                $this->usetype =  $stockout->usetype;
                $this->chef =  $stockout->chef;
                $this->product_economate_id =  $stockout->product_economate_id;
                $this->quantity =  $stockout->quantity;
                $this->unit =  $stockout->unit;


               
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

        public function searchStockOut($startdate,$enddate)
        {
            try {
                if ($startdate != null and $enddate != null) {
                    
                    $start = Carbon::parse($startdate)->format('Y-m-d') .' 00:00:00';
                    $end   = Carbon::parse($enddate )->format('Y-m-d') .' 23:59:59';
    
                    return StockOut::where('company_id','=',auth()->user()->company_id)
                            ->whereBetween('created_at',[$start,$end])
                            ->get();
                }else{
                   
    
                    return StockOut::where('company_id','=',auth()->user()->company_id)->get();
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



        public function update()
        {
         
             try {
              
                
                DB::beginTransaction();
             try {
           
                $stockcounter = StockCounter::where('product_economate_id','=',$this->product_economate_id)
                ->first();
              

                if ($stockcounter) {

                    if ($this->from == $this->to) {

                        $this->alert('warning', 'AVISO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Não pode dar saida para o mesmo local'
                        ]);

                        return;
                    }
                   
                    if ($this->quantity > $stockcounter->totalquantity) {
                        $this->alert('warning', 'AVISO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Quantidade Superior a disponível em estoque'
                        ]);
                    }else{



                        //Registrar Saida de Estoque


                       $stockoutupdate =  StockOut::find($this->edit);
                     
                    


                        if ($stockoutupdate) {
                        
                           $stockcounter->totalquantity -= $stockoutupdate->quantity;
                           $stockcounter->save();
                           
                           $stockcounterchange = StockCounter::where('product_economate_id','=',$this->product_economate_id)
                           ->first();


                           $stockcounterchange->totalquantity += $this->quantity;
                           $stockcounterchange->save();


                           $stockoutupdate->update([
                            'quantity'=>$this->quantity,
                            'usetype'=>$this->usetype,
                            'chef'=>$this->chef,
                            'unit'=>$this->unit,
                            'description'=>$this->description,
                          ]);
                        


                           $this->alert('success', 'SUCESSO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Operação Realizada Com Sucesso.'
                        ]);
                            

                        } 
                     
    
                    }
                } else {
                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Produto Sem estoque'
                    ]);
                }
                
                         
                 
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



            $this->clearField();
            $this->dispatch('close');

            
                
             } catch (\Throwable $th) {
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


        public function clearField()
        {
            try {
                $this->description = '';
                $this->edit = '';
                $this->startdate = '';
                $this->enddate = '';
                $this->usetype = '';
                $this->chef = '';
                $this->product_economate_id = '';
                $this->quantity = '';
                $this->unit = '';
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
           
              
              $data = $this->searchStockOut($this->startdate,$this->enddate);
              if($data->count() > 0){
    
                $company = Company::find(auth()->user()->company_id);
                $pdfContent = new Dompdf();
                $pdfContent = Pdf::loadView('livewire.report.stockout',[
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
         
            $initialdate = Carbon::parse($this->startdate)->format('Y-m-d') .' 00:00:00';
            $enddate   = Carbon::parse($this->enddate)->format('Y-m-d') .' 23:59:59';
                return (new StockOutExport($initialdate,$enddate))->download('saidas_de_estoque.xls'); 


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
