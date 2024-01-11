<?php

namespace App\Livewire\RoomManager;

use App\Models\{User,GarsonTable, GarsonTableManagement, HistoryOfAllActivities, Table};
use Carbon\Carbon;
use Illuminate\Validation\Rules\Exists;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class GarsonComponent extends Component
{
    use LivewireAlert;
    
    public $startdate = null,$enddate = null,$edit,$garson, $table;
    protected $rules = ['garson'=>'required','table'=>'required'];
    protected $messages = ['garson.required'=>'Obrigatório','table.required'=>'Obrigatório'];
    protected $listeners = ['clear'=>'clear'];

    public function hydrate()
    {
        $this->dispatch('update-select2');
    }
    public function render()
    {
        return view('livewire.room-manager.garson-component',[
            'users'=>$this->getUsers(),
            'tables'=>$this->getTables(),
            'garsons'=>$this->getGarson($this->startdate,$this->enddate),
        ])->layout('layouts.room_manager.app');
    }


    public function getUsers()
    {
        try {
            return User::where('profile','=','garçon')
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

    public function getTables()
    {
        try {
               
            return Table::where('company_id','=',auth()->user()->company_id)
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
    public function getGarson($start,$end)
    {
        try {

            if($start != null and $end != null)
            {
                $initialdate = Carbon::parse($start)->format('Y-m-d') .' 00:00:00';
                $enddate   = Carbon::parse($end )->format('Y-m-d') .' 23:59:59';

                return GarsonTable::whereBetween('created_at',[
                    $initialdate,
                    $enddate
                ])
                ->where('company_id','=',auth()->user()->company_id)
                ->get();
            
            }else{
                return GarsonTable::where('company_id','=',auth()->user()->company_id)
                 ->whereDate('created_at','=',today())
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

    public function store()
    {
       $this->validate($this->rules,$this->messages);
    
        try {

            $verify =
             GarsonTable::where('status','=','Turno Aberto')
            ->where('table','=',$this->table)
            ->get();

          
                    if (isset($verify) and $verify->count() > 0) {
                        $this->alert('warning', 'AVISO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            'text'=>'Essa mesa já foi atribuida a um garson...'
                        ]);

                    }else{


                        $garsontable =  GarsonTable::create([
                            'user_id'=>$this->garson,
                            'start'=>date('Y-m-d'),
                            'starttime'=>date('H:i'),
                            'company_id'=>auth()->user()->company_id,
                            'table'=>$this->table,
                            'status'=>'Turno Aberto',
                        ]);                  


                        //Registar a actividade de log para o registo da atribuição de mesas aos Garçons
                        $getNameOfGarson = User::find($this->garson);
                        $log = new HistoryOfAllActivities();
                        $log->tipo_acao = 'Atribuir mesa';
                        $log->descricao =  'O chefe de sala '.auth()->user()->name. auth()->user()->lastname. ' atribuiu a mesa '. $this->table. ' ao garçon '. $getNameOfGarson->name.' '.$getNameOfGarson->lastname;
                        $log->responsavel = auth()->user()->name;
                        $log->company_id = auth()->user()->company_id;
                        $log->save();                        
            
                        if ($garsontable) {
                            $this->alert('success', 'SUCESSO', [
                                'toast'=>false,
                                'position'=>'center',
                                'showConfirmButton' => true,
                                'confirmButtonText' => 'OK',
                                'text'=>'Operação realizada com sucesso'
                            ]);
            
                        }

                        $this->dispatch('clear');
                        $this->clearFields();
                    }        

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


    public function editTable($id)
    {
        
       
        try {
            $garsontable =   GarsonTable::find($id);         

            $this->edit = $id;
            $this->garson =  $garsontable->user_id ;
            $this->table =  $garsontable->table ;

                
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


    public function update()
    {
        
       
        try {

            $verify =
            GarsonTable::where('status','=','Turno Aberto')
           ->where('table','=',$this->table)
           ->get();

          

         
                   if (isset($verify) and $verify->count() > 0) {

                       $this->alert('warning', 'AVISO', [
                           'toast'=>false,
                           'position'=>'center',
                           'showConfirmButton' => true,
                           'confirmButtonText' => 'OK',
                           'text'=>'Essa mesa já foi atribuida a um garson...'
                       ]);

                         

                   }else{

                       $garsontablemanagement = GarsonTable::find($this->edit)->update([
                         'table'=>$this->table
                       ]);

                       //Registar a actividade para o acto de editar as mesas atribuidas
                       $log = new HistoryOfAllActivities();
                       $getNameOfGarson = User::find($this->garson);
                       
                       $log->tipo_acao = 'Editar mesa atribuída';
                       $log->descricao = 'O chefe de sala '. auth()->user()->name.' editou para a mesa '.$this->table.' ao garçon '.$getNameOfGarson->name.''.$getNameOfGarson->lastname;
                       $log->responsavel = auth()->user()->name.''.auth()->user()->lastname;
                       $log->save();

                            if ($garsontablemanagement) {
                                $this->alert('success', 'SUCESSO', [
                                    'toast'=>false,
                                    'position'=>'center',
                                    'showConfirmButton' => true,
                                    'confirmButtonText' => 'OK',
                                    'text'=>'Atribuição anulada.'
                                ]);
                    
                                $this->clearFields();
                            }
                                

                   }

        



            
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


    public function editGarsonTable($id)
    {
        try {
            $garsontable = GarsonTable::find($id);
            $this->edit = $id;
            $this->garson = $garsontable->user_id;
            $this->table = $garsontable->table;


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


    public function clearFields()
    {
        try {
            $this->table = '';
            $this->garson = '';
            $this->edit = '';
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
