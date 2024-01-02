<?php

namespace App\Livewire\Site;

use Livewire\Component;
use App\Models\{Item,Category, Company, Reserve};
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class MakeBookComponent extends Component
{
    use LivewireAlert;
    public $category,$name,$email,$datetime,$amountOfPeople,$description,$companyid;

    protected $rules = [
         'name'=>'required',
        'email'=>'required',
        'datetime'=>'required',
        'amountOfPeople'=>'required',
        'companyid'=>'required',
    ];
    protected $messages = [
        'name.required'=>'Obrigatório',
        'email.required'=>'Obrigatório',
        'datetime.required'=>'Obrigatório',
        'amountOfPeople.required'=>'Obrigatório',
        'companyid.required'=>'Obrigatório',
    ];
    public function render()
    {
        return view('livewire.site.make-book-component',[
            'companies'=>Company::get(),
        ])->layout('layouts.site.app');
    }

    

    public function save()
    {
        $this->validate($this->rules,$this->messages);
         try {
            $reserves = Reserve::where('company_id','=',$this->companyid)->get();
            if ($reserves->count() > 0 ) {
                # code...
                foreach ($reserves as $item) {
                    $datetimeformat = Carbon::parse($this->datetime)->format('Y-m-d H:i').':00';
                    if ($item->datetime == $datetimeformat) {
                     
                        $this->alert('warning', 'AVISO', [
                        'toast'=>false,
                        'position'=>'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'OK',
                        'text'=>'Data de Reserva Indisponível de momento...'
                    ]);
                }
            }
            
        }else{
            
         
            Reserve::create([
                'client'=>$this->name,
                'email'=>$this->email,
                'datetime'=>$this->datetime,
                'clientCount'=>$this->amountOfPeople,
                'company_id'=>$this->companyid,
                'description'=>$this->description,
            ]);


            $this->alert('success', 'SUCESSO', [
                'toast'=>false,
                'position'=>'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'text'=>'Sua reserva foi marcada'
            ]);

            $this->clearField();

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
   

    

public function clearField()
{
    $this->name = '';
    $this->email = '';
    $this->datetime = '';
    $this->amountOfPeople = '';
    $this->description = '';
    $this->companyid = '';
}
 





}
