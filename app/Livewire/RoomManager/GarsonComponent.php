<?php

namespace App\Livewire\RoomManager;

use App\Models\{User,GarsonTable, Table};
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
                            ->where('status','=','Turno Aberto')
                            ->first();
                            
                          

                if($exist){

                    $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'O Este garson já tem o turno aberto, primeiro deve fecha-lo.'
                    ]);

                }else{

                   $garson = GarsonTable::create([
                          'user_id'=>$this->garson,
                          'table'=>$this->table,
                          'start'=>date('Y-m-d'),
                          'starttime'=>date('H:i'),
                          'company_id'=>auth()->user()->company_id,
                          'status'=>'Turno Aberto',
                      ]);
                          
                        if($garson)
                        {
                            
                              $this->alert('success', 'SUCESSO', [
                                  'toast'=>false,
                                  'position'=>'center',
                                  'showConfirmButton' => true,
                                  'confirmButtonText' => 'OK',
                                  'text'=>'Operação Realizada Com Sucesso.'
                              ]);
             
                              $this->clearFields();
                            
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


    public function update()
    {
        $this->validate($this->rules,$this->messages);

        try {
                GarsonTable::find($this->edit)->update([
                    'user_id'=>$this->garson,
                    'table'=>$this->table,
                    'company_id'=>auth()->user()->company_id
                 ]);
            

                 $this->alert('success', 'SUCESSO', [
                     'toast'=>false,
                     'position'=>'center',
                     'showConfirmButton' => true,
                     'confirmButtonText' => 'OK',
                     'text'=>'Operação Realizada Com Sucesso.'
                 ]);

                 $this->clearFields();
           
            
            
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
