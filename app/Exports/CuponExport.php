<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Cupon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;


 class  CuponExport  implements FromQuery, WithHeadings
{
    use Exportable;
    protected $code,$date;
    public function __construct($code = null,$date = null)
    {
        $this->code = $code;
        $this->date = $date;
    }

    public  function query()
    {

        try {
          
       
        if ($this->code != null ) {
           
        return Cupon::query()->join('companies','cupons.company_id','companies.id')
            ->join('users','users.id','cupons.user_id')
            ->select('companies.companyname','cupons.code','cupons.times','cupons.type','cupons.value','users.name','users.lastname','cupons.date','cupons.expirateDate')
            ->where('cupons.company_id','=',auth()->user()->company_id)
            ->where('cupons.code','=',$this->code);
 

        }elseif($this->date != null){

            return Cupon::query()->join('companies','cupons.company_id','companies.id')
            ->join('users','users.id','cupons.user_id')
            ->select('companies.companyname','cupons.code','cupons.times','cupons.type','cupons.value','users.name','users.lastname','cupons.date','cupons.expirateDate')
            ->where('cupons.company_id','=',auth()->user()->company_id)
            ->where('cupons.date','=',$this->date);


        }elseif($this->date != null and $this->code != null ){
            Cupon::query()->join('companies','cupons.company_id','companies.id')
            ->join('users','users.id','cupons.user_id')
            ->select('companies.companyname','cupons.code','cupons.times','cupons.type','cupons.value','users.name','users.lastname','cupons.date','cupons.expirateDate')
            ->where('cupons.company_id','=',auth()->user()->company_id)
            ->where('cupons.date','=',$this->date)
            ->where('cupons.code','=',$this->code);

        } else {
          
             return Cupon::query()->join('companies','cupons.company_id','companies.id')
             ->join('users','users.id','cupons.user_id')
             ->select('companies.companyname','cupons.code','cupons.times','cupons.type','cupons.value','users.name','users.lastname','cupons.date','cupons.expirateDate')
             ->where('cupons.company_id','=',auth()->user()->company_id);
             
        }

    } catch (\Throwable $th) {
      return  redirect()->back();
    }
        
    }

    public function headings(): array
    {
        return ['Restaurante','Código','Uso','Tipo','Valor','Nome Utilizador','Sobrenome Utilizador','Data de Validade','Data de Expiração'];
    }

    

}