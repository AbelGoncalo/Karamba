<?php

namespace App\Livewire\Admin;

use App\Exports\LocalExport;
use App\Models\Company;
use App\Models\HistoryOfAllActivities;
use Livewire\Component;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LocationComponent extends Component
{
    use LivewireAlert,WithFileUploads;
    public $location, $price,$edit,$search;

    protected $rules = ['location'=>'required|unique:locations,location','price'=>'required'];
    protected $messages = ['price.required'=>'Obrigatório','location.required'=>'Obrigatório','location.unique'=>'Já Existe'];
    protected $listeners = ['close'=>'close','delete'=>'delete'];

    public function render()
    {
        return view('livewire.admin.location-component',[
            'locations'=>$this->searchLocation($this->search)
        ])->layout('layouts.admin.app');
    }

    
    //Salvar Categoria
    public function save()
    {
        $this->validate($this->rules,$this->messages);
        try {
           
            Location::create([
                'location'=>$this->location,
                'price'=>$this->price,
                'company_id'=>auth()->user()->company_id,
            ]);

            //Log para registar o local de entregas
            $log = new HistoryOfAllActivities();
            $log->tipo_acao = 'Adicionar local de entregas';
            $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
            $log->company_id = auth()->user()->company_id;
            $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' adicionou '.$this->location.' como local de entregas'.' com o preço de '.$this->price.',00 Kzs';
            $log->save();

            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);

            $this->clear();
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
    //Editar categoria
    public function editLocation($id)
    {
        
       
        try {
           
            $location = Location::find($id);
            $this->edit = $location->id;
            $this->location = $location->location;
            $this->price = $location->price;

            
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
    //confirmar exclusao de  categoria
    public function confirmDelete($id)
    {
        
       
        try {
            $this->edit = $id;
            $location = Location::find($id);
             //Log para excluir o local de entregas
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Excluir local de entregas';
             $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' excluiu o local de entregas '.$location->location;
             $log->save();
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente excluir? Não pode reverter a ação",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Excluir',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'onConfirmed' => 'delete' 
            ]);
            
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
    //Update categoria
    public function update()
    {
        $this->validate([
            'location'=>'required|unique:categories,description,'.$this->edit
        ],$this->messages);
       
        try {
           

           
            Location::find($this->edit)->update([
                'location'=>$this->location,
                'price'=>$this->price,
            ]);

             //Log para atualizar o local de entregas
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Atualizar local de entregas';
             $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' atualizou o local de entregas para '.$this->location.' com o preço de '.$this->price.' Kzs';
             $log->save();
            


            $this->dispatch('close');
            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);
            $this->clear();

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
    //excluir categoria
    public function delete()
    {
       
       
        try {
           
            Location::destroy($this->edit);
           
            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);
            $this->clear();

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
    //Pesquisar Categoria
    public function searchLocation($search)
    {
        try {

            if($search != null)
            {
                return Location::where('location','like','%'.$search.'%')
                ->where('company_id','=',auth()->user()->company_id)
                ->get();
            }else{
                return Location::
                        where('company_id','=',auth()->user()->company_id)
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


    //Limpar campos
    public function clear()
    {
        $this->location = '';
        $this->price = '';
        $this->edit = '';
        $this->search = '';
    }


    public function export()
    {
        try {

             //Log para exportar o relatório  de locais de entregas em Excel
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Exportar relatório de locais de entregas';
             $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' exportou o relatório  de locais de entregas em Excel';
             $log->save();
         
            
                return (new LocalExport($this->search))->download('Localizações.xls',\Maatwebsite\Excel\Excel::XLS); 

            

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
               
                $data = $this->searchLocation($this->search);

                if($data->count() > 0){

                //Log para exportar o relatório  de locais de entregas em PDF
                $log = new HistoryOfAllActivities();
                $log->tipo_acao = 'Exportar relatório de locais de entregas';
                $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
                $log->company_id = auth()->user()->company_id;
                $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' exportou o relatório  de locais de entregas em PDF';
                $log->save();

                $company = Company::find(auth()->user()->company_id);
                $pdfContent = new Dompdf();
                $pdfContent = Pdf::loadView('livewire.report.locations',[
                'data'=>$data,
                'company'=>$company,
                     
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
