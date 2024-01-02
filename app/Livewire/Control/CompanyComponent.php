<?php

namespace App\Livewire\Control;

use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\{Component,WithFileUploads};
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CompanyComponent extends Component
{
    use LivewireAlert,WithFileUploads;
    protected $listeners = ['close'=>'close'];
    public $search,$edit;
    public $companyid,$companyname,$companynif,$companyregime,$companyphone,
    $companyalternativephone,$companyemail,$companybusiness,
    $companyprovince,$companymunicipality,$companyaddress,
    $companylogo,$companywebsite,$companycountry,$companyslogan,$companycoin;
   
    
    
    //Validacao
protected $rules = [
"companyname"=>"required|min:2",
"companynif"=>"required|required|unique:companies,companynif",
"companyregime"=>"required",
"companyphone"=>"required",
"companyemail"=>"required|unique:companies,companyemail",
"companycountry"=>"required",
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
"companyemail.unique"=>"Já esta sendo usado",
"companynif.unique"=>"Já esta sendo usado",
"companyprovince.required"=>"Campo obrigratório",
"companymunicipality.required"=>"Campo obrigratório",
"companyaddress.required"=>"Campo obrigratório",
"companycountry.required"=>"Campo obrigratório",
"companycoin.required"=>"Campo obrigratório",

];
    public function render()
    {
        return view('livewire.control.company-component',[
            'companies'=>$this->getCompanies($this->search)
        ])->layout('layouts.control.app');
    }

    public function getCompanies($search)
    {
        try {

            if ($search != null) {
                
                return Company::where('companyname','like','%'.$search.'%')
                                ->Orwhere('companynif','=',$search)
                                ->get();
 
            }else{

                return Company::get();
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
       public function save(){
       DB::beginTransaction();
        $this->validate($this->rules,$this->message);

        try {
     
                 
                    $imageString = '';

                    if($this->companylogo)
                    {
                        $imageString = md5($this->companylogo->getClientOriginalName()).'.'.
                                 $this->companylogo->getClientOriginalExtension();
        
        
                                 $this->companylogo->storeAs('public/logo/',$imageString);
        
        
                    }
                
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
                     "companyordercode"=>'REST'.rand(),
                 ]);


                 if ($company) {
                    User::create([
                        'name'=>'Administrador',
                        'lastname'=>'Administrador',
                        'phone'=>$this->companyphone,
                        'profile'=>'administrador',
                        'status'=>'1',
                        'email'=>$company->companyemail,
                        'password'=>Hash::make($company->companyemail),
                        'acceptterms'=>1,
                        'company_id'=>$company->id,
                    ]);

                    $this->alert('success', 'SUCESSO', [
                       'toast'=>false,
                       'position'=>'center',
                       'showConfirmButton' => true,
                       'confirmButtonText' => 'OK',
                       'text'=>'Operação realizada com sucesso'
                   ]);

                 }

            $this->clearFields(); 
            DB::commit();
        }catch(Exception $th){
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
       //Metodo para Salvar dados
       public function update(){
        $this->validate([
            "companyname"=>"required|min:2",
            "companynif"=>"required|unique:companies,companyenif,".$this->edit,
            "companyregime"=>"required",
            "companyphone"=>"required",
            "companyemail"=>"required|unique:companies,companyemail,".$this->edit,
            "companycountry"=>"required",
            "companyprovince"=>"required",
            "companymunicipality"=>"required",
            "companyaddress"=>"required",
        ],$this->message);

        try{
            $company = Company::find($this->edit);
     
                 
                    $imageString = '';

                    if($this->companylogo and !is_string($this->companylogo))
                    {
                        $imageString = md5($this->companylogo->getClientOriginalName()).'.'.
                        $this->companylogo->getClientOriginalExtension();
                        $this->companylogo->storeAs('public/logo/',$imageString);
        
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
                        
                        $this->dispatch('close');
                    }else{

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
                        $this->clearFields(); 
                        $this->dispatch('close'); 
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


    public function editCompany($id)
    {
        try {
            $this->edit = $id;

            $company =  Company::find($id);
 
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
            $this->companyname = "";
            $this->companynif = "";
            $this->companyregime = "";
            $this->companyphone = "";
            $this->companyalternativephone = "";
            $this->companyemail = "";
            $this->companybusiness = "";
            $this->companyslogan = "";
            $this->companycoin ="Kwanza(AO)";
            $this->companycountry = "";
            $this->companyprovince = "";
            $this->companymunicipality ="";
            $this->companyaddress ="";
            $this->companylogo ="";
            $this->companywebsite = "";
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
