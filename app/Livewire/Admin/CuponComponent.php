<?php

namespace App\Livewire\Admin;

use App\Exports\CuponExport;
use Livewire\Component;
use App\Models\{Company, Cupon,User};
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rap2hpoutre\FastExcel\FastExcel;
use OpenSpout\Common\Entity\Style\Style;

class CuponComponent extends Component
{
    use LivewireAlert,WithFileUploads;

    public $code,$user,$edit,$expirateDate,$search,$codeSearch,$confirm,$type,$value,$select,$times;
    protected $listeners = ["deleted"=>"deleted","close"=>"close"];
    protected $rules = ['type'=>'required','value'=>'required','user'=>'required','expirateDate'=>'required','times'=>'required',];
    protected $messages = ['type.required'=>'Campo Obrigatório','value.required'=>'Campo Obrigatório','expirateDate.required'=>'Campo Obrigatório','user.required'=>'Campo Obrigatório','times.required'=>'Campo Obrigatório'];

    public function render()
    {
        //ANTES DE EXIBIR A VIEW DE CUPONS VÉRIFICAR SE HÁ CUPONS EXPIRADOS
        // SE HOUVER MARCAR COMO EXPIRADO E MOSTRAR PARA O USUÁRIO
        $isValid = Cupon::get();
        if(isset($isValid) and  $isValid->count() > 0 ){
        
            foreach($isValid as $item){
                if($item->expirateDate < date('Y-m-d')){
                    $item->status = 0;
                    $item->save();
                }
            }
        }
        
        return view('livewire.admin.cupon-component',[
            'cupons'=>$this->list($this->search,$this->codeSearch),
            'users'=>$this->selectUser($this->select),
        ])->layout('layouts.admin.app');
    }

    public function list($search = null,$codeSearch =null)
    {
        try {
            if(isset($codeSearch) and strlen($codeSearch) > 0)
            {
                return 
                    Cupon::where('code','=',$codeSearch)
                    ->where('company_id','=',auth()->user()->company_id)
                                ->orderBy("id","desc")->get();

            }elseif(isset($search) and strlen($search) > 0){
                return 
                Cupon::where('date','=',$search)
                        ->where('company_id','=',auth()->user()->company_id)
                            ->orderBy("id","desc")->get();
            
            }else{
                return 
                Cupon::orderBy("id","desc")
                ->where('company_id','=',auth()->user()->company_id)
                ->get();
            }

        } catch (\Exception $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
        }
    }


      //MÉTODO PARA CADASTRAR CUPON
      public function store()
      {

       
          
           $this->validate($this->rules,$this->messages);
           
          try {
              if($this->expirateDate == date('Y-m-d'))
              {
                  

                   $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'A data de válidade deve ser maior que a data actual.'
                ]);
  
                 
              }else{

           
              //GERAR CÓDIGO ÚNICO PARA CADA CUPON
              $this->code = 'CPD'.rand(100,500);
                  
              Cupon::create([
                  "code"=>$this->code,
                  "type"=>$this->type,
                  "value"=>$this->value,
                  "user_id"=>$this->user,
                  "date"=>date('Y-m-d'),
                  "expirateDate"=>$this->expirateDate,
                  "times"=>$this->times,
                  "company_id"=>auth()->user()->company_id,
                   
                ]);
  
                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação Realizada Com Sucesso.'
                ]);
               $this->clear();
            }
          } catch (\Exception $th) {
           
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
          }
      }

        //MÉTODO PARA EDITAR CUPON
    public function editCupon($id)
    {
        try {
            $Cupon = Cupon::find($id);
            $this->code  = $Cupon->code ;
            $this->type = $Cupon->type;
            $this->value = $Cupon->value;
            $this->user = $Cupon->user_id;
            $this->expirateDate = $Cupon->expirateDate;
            $this->edit = $Cupon->id;
         
        } catch (\Exception $th) {
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
     ;
        try {

            if($this->expirateDate == date('Y-m-d'))
            {
                $this->alert('warning', 'AVISO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'A data de válidade deve ser maior que a data actual.'
                ]);

                 
            }else{

                Cupon::find($this->edit)->update([
                    "code"=>$this->code,
                    "type"=>$this->type,
                    "value"=>$this->value,
                    "user_id"=>$this->user,
                    "date"=>date('Y-m-d'),
                    "expirateDate"=>$this->expirateDate,
                    "times"=>$this->times,
                ]);
    
                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação Realizada Com Sucesso.'
                ]);

                 $this->dispatch("close");
                 $this->clear();
            }


        } catch (\Exception $th) {

             $this->dispatch("error",[
                "message"=>"Erro ao Realizar Operação.\n\n\n".$th->getMessage()
             ]);
        }
    }

    

      //MÉTODO PARA PESQUISAR O USUÁRIO NO QUAL SERÁ GERADO O CUPON
      public function selectUser($select  = null)
      {
          try {
              if(isset($select) and strlen($select) > 0)
              {
                  return  User::where('name','like','%'.$select.'%')
                            ->where('profile','=','client')
                            ->where('company_id','=',auth()->user()->company_id)
                            ->orderBy("id","desc")->get();
                     
  
                  
              }else{
                  return User::where('profile','=','client')
                            ->orderBy("id","desc")
                            ->where('company_id','=',auth()->user()->company_id)
                            ->get();
                  
                          
              }
  
          } catch (\Exception $th) {
  
              $this->dispatch("error",[
                  "message"=>"Erro ao Realizar Operação."
              ]);
          }
      }


      public function clear()
      {
          try {
              $this->code = "";
              $this->type = "";
              $this->edit = "";
              $this->confirm = "";
              $this->times = "";
              $this->value = "";
              $this->expirateDate = "";
            //   $this->date = "";
             
            
          } catch (\Exception $th) {
  
              $this->dispatch("error",[
                  "message"=>"Erro ao Realizar Operação.\n\n\n".$th->getMessage()
               ]);
          }
      }

      //confirmar exclusao de  categoria
    public function confirmDelete($id)
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
                'onConfirmed' => 'deleted' 
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


       //MÉTODO PARA EXCLUIR O CUPON DE FACTO
       public function deleted()
       {
           try {
   
               Cupon::destroy($this->edit);
               $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Operação Realizada Com Sucesso.'
            ]);
               $this->clear();
   
           } catch (\Exception $th) {
            $this->alert('error', 'ERRO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Falha ao realizar operação'
            ]);
           }
       }


      


       public function export($format)
       {
           try {
            
               if($format == 'pdf')
               {
                   return (new CuponExport($this->codeSearch,$this->expirateDate))->download('categorias.'.$format,\Maatwebsite\Excel\Excel::DOMPDF); 
                   
               }elseif($format == 'xls')
               {
                   return (new CuponExport($this->codeSearch,$this->expirateDate))->download('categorias.'.$format,\Maatwebsite\Excel\Excel::XLS); 
   
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
