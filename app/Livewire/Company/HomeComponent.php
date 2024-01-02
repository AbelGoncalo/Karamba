<?php

namespace App\Livewire\Company;

use App\Models\Company;
use App\Models\User;
use Exception;
use Livewire\{Component,WithFileUploads};
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HomeComponent extends Component
{
    use LivewireAlert,WithFileUploads;
    protected $listeners = ['refresh'=>'refresh'];

    public function render()
    {
        return view('livewire.company.home-component')->layout('layouts.admin.app');
    }

    public $companyid,$companyname,$companynif,$companyregime,$companyphone,
            $companyalternativephone,$companyemail,$companybusiness,
            $companyprovince,$companymunicipality,$companyaddress,
            $companylogo,$companywebsite,$companycountry,$companyslogan,$companycoin,$companyordercode;
           
            
            
            //Validacao
    protected $rules = [
        "companyname"=>"required|min:2",
        "companynif"=>"required",
        "companyregime"=>"required",
        "companyphone"=>"required",
        "companyemail"=>"required|unique:companies,companyemail",
        "companycountry"=>"required",
        "companycoin"=>"required",
        "companyprovince"=>"required",
        "companymunicipality"=>"required",
        "companyaddress"=>"required",

    ];
    protected $message =[
        "companyname.required"=>"Campo obrigratório",
        "companyname.min"=>"Campo deve ter pelomenos 2 caracteres",
        "companynif.required"=>"Campo obrigratório",
        "companyregime.required"=>"Campo obrigratório",
        "companyphone.required"=>"Campo obrigratório",
        "companyemail.required"=>"Campo obrigratório",
        "companyemail.email"=>"Email inválido",
        "companyprovince.required"=>"Campo obrigratório",
        "companymunicipality.required"=>"Campo obrigratório",
        "companyaddress.required"=>"Campo obrigratório",
        "companycountry.required"=>"Campo obrigratório",
        "companycoin.required"=>"Campo obrigratório",
        "companyemail.unique"=>"Já existe",

    ];
    public function updated($fields){
        $this->validateOnly($fields,$this->rules,$this->message);
    }
    //Metodo que é executado quando a pagina é carregada
     public function mount(){
         try {
             $company =  Company::find(auth()->user()->company_id);
            
            if ($company) {
 
                $this->companyname = $company->companyname ?? "";
                $this->companynif = $company->companynif ?? "";
                $this->companyregime = $company->companyregime ?? "";
                $this->companyphone = $company->companyphone ?? "";
                $this->companyalternativephone = $company->companyalternativephone ?? "";
                $this->companyemail = $company->companyemail ?? "";
                $this->companybusiness = $company->companybusiness ?? "";
                $this->companyslogan = $company->companyslogan ?? "";
                $this->companycoin = $company->companycoin ?? "Kwanza(AO)";
                $this->companycountry = $company->companycountry ?? "";
                $this->companyprovince = $company->companyprovince ?? "";
                $this->companymunicipality = $company->companymunicipality ?? "";
                $this->companyaddress = $company->companyaddress ?? "";
                $this->companylogo = $company->companylogo ?? "";
                $this->companywebsite = $company->companywebsite ?? "";
                $this->companyordercode = $company->companyordercode ?? "";
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
    //Metodo para Salvar dados
    public function update(){
        $this->validate([
            "companyname"=>"required|min:2",
            "companynif"=>"required",
            "companyregime"=>"required",
            "companyphone"=>"required",
            "companyemail"=>"required|unique:companies,companyemail,".auth()->user()->company_id,
            "companycountry"=>"required",
            "companycoin"=>"required",
            "companyprovince"=>"required",
            "companymunicipality"=>"required",
            "companyaddress"=>"required",
        ],$this->message);

        try{
            $company = Company::find(auth()->user()->company_id);
            if ($company) {
                 
                    $imageString = '';
                    if($this->companylogo and !is_string($this->companylogo))
                    {
                        $imageString = md5($this->companylogo->getClientOriginalName()).'.'.
                                 $this->companylogo->getClientOriginalExtension();
        
        
                                 $this->companylogo->storeAs('public/',$imageString);
        
        
                    }
                
                $company->update([
                     "companyname"=>$this->companyname,
                     "companynif"=>$this->companynif,
                     "companyregime"=>$this->companyregime,
                     "companyphone"=>$this->companyphone,
                     "companyalternativephone"=>$this->companyalternativephone,
                     "companyemail"=>$this->companyemail,
                     "companybusiness"=>$this->companybusiness,
                     "companyslogan"=>$this->companyslogan,
                     "companyprovince"=>$this->companyprovince,
                     "companycountry"=>$this->companycountry,
                     "companymunicipality"=>$this->companymunicipality,
                     "companyaddress"=>$this->companyaddress,
                     "companylogo"=>$imageString,
                     "companywebsite"=>$this->companywebsite,
                     "companycoin"=>$this->companycoin ?? "Kwanza(AO)",
                 ]);

                 $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação realizada com sucesso'
                ]);

                $this->mount();

            }else{

                $imageString = '';
                    if($this->companylogo and !is_string($this->companylogo))
                    {
                        $imageString = md5($this->companylogo->getClientOriginalName()).'.'.
                                 $this->companylogo->getClientOriginalExtension();
        
        
                                 $this->companylogo->storeAs('public/',$imageString);
                                 
                                 
                                  $company =   Company::create([
                    "companyname"=>$this->companyname,
                    "companynif"=>$this->companynif,
                    "companyregime"=>$this->companyregime,
                    "companyphone"=>$this->companyphone,
                    "companyalternativephone"=>$this->companyalternativephone,
                    "companyemail"=>$this->companyemail,
                    "companybusiness"=>$this->companybusiness,
                    "companyslogan"=>$this->companyslogan,
                    "companyprovince"=>$this->companyprovince,
                    "companycountry"=>$this->companycountry,
                    "companymunicipality"=>$this->companymunicipality,
                    "companyaddress"=>$this->companyaddress,
                    "companylogo"=>$imageString,
                    "companywebsite"=>$this->companywebsite,
                    "companycoin"=>$this->companycoin ?? "Kwanza(AO)",
                ]);
                


                $currentUser  = User::find(auth()->user()->id);
                $currentUser->company_companyid = $company->id;
                $currentUser->save();

                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação realizada com sucesso'
                ]);
                $this->mount();
        
        
                    }else{
                        
                        
                         $company =   Company::create([
                    "companyname"=>$this->companyname,
                    "companynif"=>$this->companynif,
                    "companyregime"=>$this->companyregime,
                    "companyphone"=>$this->companyphone,
                    "companyalternativephone"=>$this->companyalternativephone,
                    "companyemail"=>$this->companyemail,
                    "companybusiness"=>$this->companybusiness,
                    "companyslogan"=>$this->companyslogan,
                    "companyprovince"=>$this->companyprovince,
                    "companycountry"=>$this->companycountry,
                    "companymunicipality"=>$this->companymunicipality,
                    "companyaddress"=>$this->companyaddress,
                  
                    "companywebsite"=>$this->companywebsite,
                    "companycoin"=>$this->companycoin ?? "Kwanza(AO)",
                ]);
                


                $currentUser  = User::find(auth()->user()->id);
                $currentUser->company_companyid = $company->id;
                $currentUser->save();

                $this->alert('success', 'SUCESSO', [
                    'toast'=>false,
                    'position'=>'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'text'=>'Operação realizada com sucesso'
                ]);
                $this->mount();
                    }
               

            }

               

               
            
        }catch(Exception $th){
          
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
