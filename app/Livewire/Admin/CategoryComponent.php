<?php

namespace App\Livewire\Admin;

use App\Exports\CategoryExporter;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Company;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryExport;
use App\Livewire\Admin\HistoryOfAllActivities as AdminHistoryOfAllActivities;
use App\Models\HistoryOfAllActivities;
use App\Models\Item;

class CategoryComponent extends Component
{
    use LivewireAlert,WithFileUploads;
    public $description, $image,$edit,$search;

    protected $rules = ['description'=>'required|unique:categories,description'];
    protected $messages = ['description.required'=>'Obrigatório','description.unique'=>'Já Existe'];
    protected $listeners = ['close'=>'close','delete'=>'delete'];

    public function render()
    {
        if(Category::count() == 0)
        {
            $data = ['Pratos','Bebidas'];
            foreach ($data as $value) {
                Category::create([
                    'description'=>$value,
                    'company_id'=>auth()->user()->company_id
                ]);
            }
        }

        $items = Item::get();
        return view('livewire.admin.category-component',[
            'categories'=>$this->searchCategory($this->search),
            'items' =>$items
        ])->layout('layouts.admin.app');
    }

    //Salvar Categoria
    public function save()
    {
        $this->validate($this->rules,$this->messages);
        try {
            $imageString = '';
            if($this->image)
            {
                $imageString = md5($this->image->getClientOriginalName()).'.'.
                         $this->image->getClientOriginalExtension();


                         $this->image->storeAs('public/',$imageString);


            }

            Category::create([
                'description'=>$this->description,
                'image'=>$imageString,
                'company_id'=>auth()->user()->company_id

            ]);

             //Log de adicionar categoria
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Adicionar categoria';
             $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
             $log->descricao = 'O Administrador '.auth()->user()->name.' Adicionou a categoria '.$this->description.' ao sistema';
             $log->company_id = auth()->user()->company_id;
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
    public function editCategory($id)
    {
        
       
        try {
           
            $category = Category::find($id);
            $this->edit = $category->id;
            $this->description = $category->description;
            $this->image = $category->image;


            
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
    //Update categoria
    public function update()
    {
        $this->validate([
            'description'=>'required|unique:categories,description,'.$this->edit
        ],$this->messages);
       
        try {
           

            if($this->image and !is_string($this->image))
            {
                $imageString = md5($this->image->getClientOriginalName()).'.'.
                         $this->image->getClientOriginalExtension();
                         $this->image->storeAs('public/',$imageString);

            Category::find($this->edit)->update([
                'description'=>$this->description,
                'image'=>$imageString,
            ]);

            
           

            }else{
                Category::find($this->edit)->update([
                    'description'=>$this->description,
                ]);

                
            //Log para atualizar a categoria
            $log = new HistoryOfAllActivities();
            $log->tipo_acao = 'Atualizar categoria';
            $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
            $log->company_id = auth()->user()->company_id;
            $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' actualizou a categoria para '.$this->description;
            $log->save();

            }


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
            
            $category = Category::find($this->edit);
            Category::destroy($this->edit);

             //Log para excluir  a categoria
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Excluir categoria';
             $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' excluiu a categoria  '.$category->description;
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
    //Pesquisar Categoria
    public function searchCategory($search)
    {
        try {

            if($search != null)
            {
                return Category::where('company_id','=',auth()->user()->company_id)
                ->where('description','like','%'.$search.'%')
                ->get();
            }else{
                return Category::where('company_id','=',auth()->user()->company_id)
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
        $this->description = '';
        $this->image = '';
        $this->edit = '';
        $this->search = '';
    }


    public function export($format)
    {
        try {
         
            if($format == 'pdf')
            {

            //Log para exportar o relatório de categorias em Excel
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Exportar categoria ';
             $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' exportou o relatório de categorias em PDF';
             $log->save();

                return (new CategoryExport($this->search))->download('categorias.'.$format,\Maatwebsite\Excel\Excel::DOMPDF); 
                
            }elseif($format == 'xls')
            {

            //Log para exportar o relatório de categorias em Excel
             $log = new HistoryOfAllActivities();
             $log->tipo_acao = 'Exportar categoria ';
             $log->responsavel = auth()->user()->name.' '.auth()->user()->lastname;
             $log->company_id = auth()->user()->company_id;
             $log->descricao = 'O Administrador '. auth()->user()->name.' '.auth()->user()->lastname.' exportou o relatório de categorias em Excel';
             $log->save();

                return (new CategoryExport($this->search))->download('categorias.'.$format,\Maatwebsite\Excel\Excel::XLS); 

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
