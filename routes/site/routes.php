<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Site\{Contact, FinallyComponent};

Route::get('/',[SiteController::class,'index'])->name('site.home');
Route::get('/sobre',[SiteController::class,'about'])->name('site.about');
Route::get('/restaurantes',[SiteController::class,'getCompanies'])->name('site.companies');
Route::get('/restaurante/menu/{id}',[SiteController::class,'getMenu'])->name('site.company');
Route::get('/restaurante/carrinho',[SiteController::class,'getCart'])->name('site.cart');
Route::get('/minhas/encomendas',FinallyComponent::class)->name('site.my.orders');



