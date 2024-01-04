<?php

namespace App\Livewire\RoomManager;

use App\Models\{User,GarsonTable, GarsonTableManagement, Table};
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
    protected $listeners = ['delete'=>'delete','clear'=>'clear'];

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

                //Verificar se o garson já tem um turno aberto

             

                    $exist = GarsonTable::where('user_id','=',$this->garson)
                    ->where('company_id','=',auth()->user()->company_id)
                    ->where('status','=','Turno Aberto')
                    ->first();
            
                //Verificar se o garson já tem mesa atribuida a ele
                if(isset($exist) and $exist->count() > 0)
                {

                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        "timer"=> 2000,
                        'text'=>"O garçon que pretende atruir mesa, já tem a mesas atruidas e turno aberto!!!"
                    ]);


                }else{
                    
                    $collections = GarsonTableManagement::join('garson_tables','garson_table_management.garson_table_id','=','garson_tables.id')
                    ->select('garson_table_management.table')
                    ->where('garson_tables.status','=','Turno Aberto')
                    ->where('garson_tables.company_id','=',auth()->user()->company_id)
                    ->get();
                     
               

                if(isset($collections) and $collections->count() > 0){
                    $existe = [];
                    foreach ($collections as  $value) {
                        
                        foreach ($this->table as  $item) {
                            if ($value->table == $item) {
                                array_push($existe,$value->table);
                             }
                        }
                    }


                        
                    if (isset($existe) and count($existe) > 0) {
                        # code...
                        $this->alert('warning', 'AVISO', [
                            'toast'=>false,
                            'position'=>'center',
                            'showConfirmButton' => true,
                            'confirmButtonText' => 'OK',
                            "timer"=> 5000,
                            'text'=>" A(s) ".implode(" ",$existe)." já foram atribuidas a outro garçon "
                        ]);
                    } else {
                        $garson = GarsonTable::create([
                            'user_id'=>$this->garson,
                            'table'=>$this->table,
                            'start'=>date('Y-m-d'),
                            'starttime'=>date('H:i'),
                            'company_id'=>auth()->user()->company_id,
                            'status'=>'Turno Aberto',
                        ]);
  
                        foreach ($this->table as $item) {
                          GarsonTableManagement::create([
                              'garson_table_id'=>$garson->id,
                              'table'=>$item,
                              'company_id'=>auth()->user()->company_id,
                          ]);
                        }
                    }
                    
                    $this->dispatch('clear');

                }else{

                   
                   $garson = GarsonTable::create([
                          'user_id'=>$this->garson,
                          'table'=>$this->table,
                          'start'=>date('Y-m-d'),
                          'starttime'=>date('H:i'),
                          'company_id'=>auth()->user()->company_id,
                          'status'=>'Turno Aberto',
                      ]);

                      foreach ($this->table as $item) {
                        GarsonTableManagement::create([
                            'garson_table_id'=>$garson->id,
                            'table'=>$item,
                            'company_id'=>auth()->user()->company_id,
                        ]);
                      }
                     
                    
                      $this->dispatch('clear');

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


    public function confirmDelete($id)
    {
        
       
        try {
            $this->edit = $id;
       
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja realmente anular está atribuição? Não pode reverter a ação",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Anular',
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


    public function delete()
    {
        
       
        try {
            
       
          $delete =  GarsonTable::find($this->edit);
 
          $garsontablemanagement = GarsonTableManagement::where('garson_table_id','=',$delete->id)->delete();

          if($garsontablemanagement)
          {
              $delete->delete();

            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Atribuição anulada.'
            ]);
            



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
