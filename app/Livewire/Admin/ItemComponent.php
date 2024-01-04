<?php

namespace App\Livewire\Admin;

use App\Exports\ItemExport;
use Livewire\Component;
use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class ItemComponent extends Component
{
    use LivewireAlert,WithFileUploads,WithPagination;
    public $description, $price,$edit,$search,$category_id,$cost = 0,$iva = 0,$barcode,$image,$quantity,$searchCategory; 
    protected $rules = ['description'=>'required|unique:items,description','price'=>'required','category_id'=>'required','quantity'=>'required'];
    protected $messages = ['description.required'=>'Obrigatório','description.unique'=>'Já Existe','price.required'=>'Obrigatório','category_id.required'=>'Obrigatório','quantity.required'=>'Obrigatório'];
    protected $listeners = ['close'=>'close','delete'=>'delete','changeStatus'=>'changeStatus'];

    public function mount()
    {
        $this->price = 0;
    }
    public function render()
    {
        return view('livewire.admin.item-component',[
            'items'=>$this->searchItem($this->search,$this->searchCategory),
            'categories'=>$this->getCategories()
        ])->layout('layouts.admin.app');
    }


 

    public function getCategories()
    {
        try {
           return Category::where('company_id','=',auth()->user()->company_id)->get();
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
     //Salvar Item
     public function save()
     {
         $this->validate($this->rules,$this->messages);
         try {
            //Verificar se o price é nulo
            if($this->price <= 0)
            {
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Preço não pode ser nulo!!!.'
                ]);

                return;
            }

            $imageString = '';

            if($this->image)
            {
           
                $imageString = md5($this->image->getClientOriginalName()).'.'.
                $this->image->getClientOriginalExtension();
                $this->image->storeAs('/public/',$imageString);

            }

             Item::create([
                 'barcode'=>$this->barcode,
                 'description'=>$this->description,
                 'price'=>$this->price,
                 'cost'=>$this->cost,
                 'quantity'=>$this->quantity,
                 'iva'=>$this->iva,
                 'image'=>$imageString,
                 'category_id'=>$this->category_id,
                 'company_id'=>auth()->user()->company_id,
             ]);
 
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
     //Editar Item
     public function editItem($id)
     {
         
        
         try {
            
             $item = Item::find($id);
             $this->edit = $item->id;
             $this->barcode = $item->barcode;
             $this->iva = $item->iva;
             $this->cost = $item->cost;
             $this->description = $item->description;
             $this->price = $item->price;
             $this->category_id = $item->category_id;
             $this->quantity = $item->quantity;
 
             
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
     public function confirm($id)
     {
         
        
         try {
             $this->edit = $id;
        
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
     //Update Item
     public function update()
     {
        
         $this->validate([
            'description'=>'required|unique:items,description,'.$this->edit,'price'=>'required','category_id'=>'required'
         ],$this->messages);
        
         try {
            $imageString = '';
            if($this->image)
            {
           
                $imageString = md5($this->image->getClientOriginalName()).'.'.
                $this->image->getClientOriginalExtension();
                $this->image->storeAs('/public/',$imageString);
            }



             Item::find($this->edit)->update([
                'barcode'=>$this->barcode,
                 'description'=>$this->description,
                 'price'=>$this->price,
                 'cost'=>$this->cost,
                 'quantity'=>$this->quantity,
                 'iva'=>$this->iva,
                 'image'=>$imageString,
                 'category_id'=>$this->category_id,
             ]);
             
 
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
     //excluir Item
     public function delete()
     {
        
        
         try {
            
             Item::destroy($this->edit);
            
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
     public function searchItem($search,$category)
     {
         try {
 
             if($search != null)
             {
                 return Item::where('description','like','%'.$search.'%')->latest()
                 ->where('company_id','=',auth()->user()->company_id)
                 ->get();
             }elseif($category != null){

                return Item::where('category_id','=',$category)->latest()
                ->where('company_id','=',auth()->user()->company_id)
                ->get();

             }else{
                 return Item::where('company_id','=',auth()->user()->company_id)
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
        $this->description  = '';
        $this->price  =0;
        $this->quantity  =0;
        $this->edit  = '';
        $this->search  = '';
        $this->cost  = 0;
        $this->iva  = 0;
        $this->image  = '';
        $this->category_id = ''; 
    }


   


     //excluir Usuarios
     public function changeStatus()
     {
        
        
         try {
            
             $item  = Item::find($this->edit);
           
             ($item->status == 'DISPONIVEL')? $item->status = 'INDISPONIVEL' : $item->status = 'DISPONIVEL';
              $item->save();
            
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


      //confirmar mudança de estado da conta  de  Usuarios
    public function confirmChangeStatus($id)
    {
        
       
        try {
            $this->edit = $id;
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente alterar o estado deste item?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Mudar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'onConfirmed' => 'changeStatus' 
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

    public function export()
    {
        try {
         
           
                return (new ItemExport($this->search))->download('items.xls',\Maatwebsite\Excel\Excel::XLS); 

            

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
                $data = $this->searchItem($this->search);

                if($data->count() > 0){
                    foreach ($data as  $value) {
                       $total +=$value->total;
                    }
      
                  $company = Company::find(auth()->user()->company_id);
                  $pdfContent = new Dompdf();
                  $pdfContent = Pdf::loadView('livewire.report.items',[
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
