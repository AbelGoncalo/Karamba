<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        try {
            $companies = Company::count();
            return view('livewire.site.pages.home',compact('companies'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');

        }
    }
    public function about()
    {
        try {
            $companies = Company::latest()->get();
            return view('livewire.site.pages.about',compact('companies'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');
        }
    }
    public function getCompanies()
    {
        try {
            $companies = Company::latest()->get();
            return view('livewire.site.pages.companies',compact('companies'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');

        }
    }
    public function getMenu($id)
    {
        try {
            $items = Item::where('company_id','=',$id)->get();
            $company = Company::find($id);
            return view('livewire.site.pages.menu',compact('items','company'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');

        }
    }

    public function getCart()
    {
        try {
            if (session('companyid') == null) {

                return redirect()->back()->with('empt-cart','Carrinho vazio!');
                
            } else {
                
                $company = Company::find(session('companyid'));
            }
            
            return view('livewire.site.pages.cart',compact('company'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Falha ao realizar Operação');

        }
    }
   

 
}
