<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = "companies";
    protected $primaryKey = "id";
    protected $fillable = [
        "companyname",
        "companynif",
        "companyregime",
        "companyphone",
        "companyalternativephone",
        "companyemail",
        "companybusiness",
        "companyprovince",
        "companymunicipality",
        "companyaddress",
        "companywebsite",
        "companylogo",
        "companycountry",
        "companyslogan",
        "companycoin",
        "companyordercode",
    ];


    public function reviews()
    {
        return $this->hasMany(Review::class, 'company_id', 'id');
    }

    
}
